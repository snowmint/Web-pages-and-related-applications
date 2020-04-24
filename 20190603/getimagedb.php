<?php
// 本程式因為目前只用一個參數即可取得照片，因此有安全疑慮，請思考如何改進！
// 變數及函式處理，請注意其順序
require_once("../include/configure.php");
require_once("../include/gpsvars.php");
require_once("../include/db_func.php");
$db_conn = connect2db($dbhost, $dbuser, $dbpwd, $dbname);
$ID = $_GET['ID'];
if (!isset($ID)) exit;

$filetype = 'image/jpeg';
$sqlcmd = "SELECT * FROM photo WHERE cid='$ID' AND Valid = 'Y'"
$rs = querydb($sqlcmd, $db_conn);
//$filename = $AttachDir . '/' . str_pad($ID, 8, '0', STR_PAD_LEFT) . '.jpg';
//$fp = @fopen($filename,'r');
$filename = $rs[0]['filename'];
if (count($rs) > 0) {
    //$output = fread($fp, filesize($filename));
    $output = $rs[0]['photo'];
    header("Content-type: $filetype ");
    header("Content-Disposition: filename=$filename");
    echo $output;
} else die ('File Not Exist!');

?>