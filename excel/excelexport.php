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
$sqlcmd = "SELECT scode,schoolname FROM uschoolcode WHERE validyear='$ThisYear'";
$rs = querydb($sqlcmd, $db_conn);
$arrUniv = array();
if (count($rs) > 0) {
    foreach ($rs as $item) {
        $uCode = $item['scode'];
        $arrUniv["$uCode"] = $item['schoolname'];
    }
}
$sqlcmd = "SELECT * FROM students WHERE category='S' AND highschool_id='$myuCode' "
    . "AND schoolyear='$ThisYear' AND valid='Y' AND status='G' "
    . "ORDER BY scode,priority ";
$rs = querydb($sqlcmd, $db_conn);
$arrStdWish = array();
$PrevsCode = '000';
$Rank = 0;
foreach ($rs as $item) {
    $StdID = $item['student_id'];
    $sCode = $item['scode'];
    $arrStdWish["$StdID"]['scode'] = $item['scode'];
    $arrStdWish["$StdID"]['gcode'] = $item['gcode'];
    if ($PrevsCode==$sCode) $Rank++;
    else {
        $Rank = 1;
        $PrevsCode = $sCode;
    }
    $arrStdWish["$StdID"]['rank'] = $Rank;
    $arrStdWish["$StdID"]['depcode'] = explode(';', $item['depcode']);
}

$sqlcmd = "SELECT * FROM students WHERE highschool_id='$myuCode' "
    . "AND schoolyear='$ThisYear' AND category='S' AND valid='Y' "
    . "ORDER BY student_id ";
$StdInfo = querydb($sqlcmd, $db_conn);
$reader = PHPExcel_IOFactory::createReader('Excel2007'); // 讀取2007 excel 檔案
$objPHPExcel = $reader->load("starlist.xlsx"); // 檔案名稱

$Row = 2;
$type = PHPExcel_Cell_DataType::TYPE_STRING;
foreach ($StdInfo as $curStd) {
    $StdID = $curStd['student_id'];
	$uName = '';
	$sCode = '';
    $gCode = $Rank = '';
    $arrDepCodes = array();
    if (isset($arrStdWish["$StdID"])) {
        $item = $arrStdWish["$StdID"];
		$sCode = $item['scode'];
        $gCode = $item['gcode'];
        $Rank = $item['rank'];
        $arrDepCodes = $item['depcode'];
        if (isset($arrUniv["$sCode"])) $uName = $arrUniv["$sCode"];
    }
    $Cell = 'D' . $Row;
    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValueByColumnAndRow(0, $Row, $StdID)
		->setCellValueByColumnAndRow(2, $Row, $uName)
        ->setCellValueExplicit($Cell, $sCode)
        ->setCellValueByColumnAndRow(4, $Row, $gCode)
        ->setCellValueByColumnAndRow(5, $Row, $Rank);
    if (count($arrDepCodes)>0) {
        $Col = 6;
        foreach ($arrDepCodes as $DepCode) {
            if (empty($DepCode)) continue;
            $Cell = $ColID[$Col] . $Row;
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValueExplicit($Cell, $DepCode);
            $Col++;
        }
    }
    $Row++;
}
// exit();
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