<?php
session_start();
require_once('../include/gpsvars.php');
require_once('../include/configure.php');
require_once('../include/db_func.php');
require_once('../Classes/PHPExcel.php'); 
// require_once('../Classes/PHPExcel/IOFactory.php');
// require_once('../Classes/PHPExcel/Reader/Excel2007.php');
// require_once('../Classes/PHPExcel/Writer/Excel2007.php');
if (!isset($_SESSION['LoginID']) || empty($_SESSION['LoginID'])) {
	header ("Location:../index.php");
	exit();
}
$db_conn = connect2db($dbhost, $dbuser, $dbpwd, $dbname);

$sqlcmd = "SELECT * FROM namelist ORDER BY cid ";
$StdInfo = querydb($sqlcmd, $db_conn);
$reader = PHPExcel_IOFactory::createReader('Excel2007'); // 讀取2007 excel 檔案
$objPHPExcel = $reader->load("contact.xlsx"); // 檔案名稱

$Row = 2;
$type = PHPExcel_Cell_DataType::TYPE_STRING;
foreach ($StdInfo as $curStd) {
    $cid = $curStd['cid'];
	$name = $curStd['name'];
	$groupid = $curStd['groupid'];
    $birthday = $curStd['birthday'];
    $phone = $curStd['phone'];
    $address = $curStd['address'];
    $valid = $curStd['valid'];
    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValueByColumnAndRow(0, $Row, $cid)//'A'.
        ->setCellValueByColumnAndRow(1, $Row, $name)
		->setCellValueByColumnAndRow(2, $Row, $groupid)
        ->setCellValueByColumnAndRow(3, $Row, $birthday)
        ->setCellValueByColumnAndRow(4, $Row, $phone)
        ->setCellValueByColumnAndRow(5, $Row, $address)
        ->setCellValueByColumnAndRow(6, $Row, $valid);
    $Row++;
}

$objPHPExcel->setActiveSheetIndex(0);
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$xlsxFile = '/tmp/exportlist.xlsx';
$OutputFile = 'starplan_' . $myuCode . '_list' . date('YmdHi') . '.xlsx';
$objWriter->save($xlsxFile);

$fp = @fopen($xlsxFile,'r');
if ($fp) {
    $output = fread($fp, filesize($xlsxFile));
    header("Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet \n");
    header("Content-Disposition: filename=$OutputFile \n");
    echo $output;
    fclose ($fp);
    unlink ($xlsxFile);
} else die ('File Not Exist!');
?>