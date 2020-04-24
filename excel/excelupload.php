<?php
ini_set("memory_limit","1024M");
set_time_limit(300);
header('Content-type: text/html; charset=utf-8');
session_start();
if (!isset($_SESSION['LoginID']) || empty($_SESSION['LoginID'])) {
    header ("Location:/index.php");
    exit();
}
require_once ("../include/gpsvars.php") ;
require_once ("../include/configure.php") ; 
require_once ("../include/db_func.php") ;
require_once ("../include/xss.php") ;
require_once ("../Classes/PHPExcel/IOFactory.php");
$db_conn = connect2db($dbhost, $dbuser, $dbpwd, $dbname);
$ErrMsg = '';
$Msg = '';
$LoginID = $_SESSION['LoginID'];
$SchYear = date('Y');
$lastupdate = date('Y-m-d H:i:s');
if (isset($upload)) {
    $fname = $_FILES['userfile']['tmp_name'];
    $fsize = $_FILES['userfile']['size'];
    
    if (!empty($fname) && $fsize>0) {
        $TotalPeocessing = 0;
        $InsertCount = 0;
        $UpdateCount = 0;
        $objPHPExcel = PHPExcel_IOFactory::load($fname);
        $sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
        if ($sheetData[1]['A'] <> '報名序號')      { $ErrMsg .= '欄位A1應為「報名序號」\n'; }
        if ($sheetData[1]['B'] <> '姓名')          { $ErrMsg .= '欄位B1應為「姓名」\n'; }
        if(!empty($ErrMsg)) $sheetData = array(); 
        $SqlcmdPrefix = 'INSERT INTO students (student_id,category,name,'
            . 'password,accesskey,highschool_id,'
            . 'schoolyear,valid,lastupdate) VALUES (';
        for ($Row=2; $Row<=count($sheetData) && empty($ErrMsg); $Row++) {
            $TotalPeocessing++;
            $KeySeed = 'A' . $ThisYear . $myuCode.$sheetData[$Row]['A'];
            $AccessKey = strtoupper(sha1($KeySeed));
			$password = substr($AccessKey,10,8);
			$student_id = $sheetData[$Row]['A'];
            $name = $sheetData[$Row]['B'];
            $name = addslashes(xsspurify($name));
            $sqlcmd = "SELECT * FROM students WHERE student_id='$student_id' AND valid='Y'"
                . "AND highschool_id='$myuCode' AND schoolyear='$SchYear' AND category='A' ";
            $rs = querydb($sqlcmd, $db_conn);
            if (count($rs) > 0) {
                $UpdateCount++;
                $RecID = $rs[0]['id'];
				$sqlcmd = "UPDATE students SET name='$name',password='$password' "
                    . "accesskey='$AccessKey' WHERE id='$RecID'";
            } else {
                $sqlcmd = $SqlcmdPrefix . "'$student_id','A','$name','$password',"
                    . "'$AccessKey','$myuCode','$SchYear','Y','$lastupdate')";
				$InsertCount++;
            }
            $result = updatedb($sqlcmd, $db_conn);
        }
    } else {
        $ErrMsg .= '檔案名稱為空白或不存在，檔案大小為0或超過上限(2MBytes)！\n';
    }

    $Msg .= date('Y-m-d H:i:s') . "處理結束。</br>";
    $Msg .= "處理 $TotalPeocessing 筆資料，匯入 $InsertCount 筆，更新 $UpdateCount 筆。</br>";

}
require_once ("../include/header.php");
$ThisPageTitle = '個人申請學生資料上傳';
?>
<body>
<div class="Outerbox">
<?php require_once('topmenu.php'); ?>
<table width="720" align="center" border="0">
<tr>
  <td>請選擇檔案，然後點選上傳檔案按鈕，即可將學生資料上傳至系統中，
  上傳的檔案大小以2MBytes為限。</td>
</tr>
<tr>
  <td>
檔案格式：Excel檔<br />
第一列(欄位A~B)：報名序號 | 姓名<br />
第二列以後依序填入資料<br />
註：第一列必須輸入上述字樣，否則資料不會被接受，如果有要變更如分梯次等資料，修改後重新上傳即可
  </td>
</tr>
</table>
<div style="width:720px;margin:12px auto 0 auto;">
<form method="post" enctype="multipart/form-data" action="">
<input type="hidden" name="MAX_FILE_SIZE" value="2100000">
<div style="text-align:center;border:2px solid brown;padding:12px 3px;">
上傳檔名：<input name="userfile" type="file">&nbsp;
<input type="submit" name="upload" value="上傳檔案">
</div>
</form>
</div>
<?php if (!empty($Msg)) { ?>
<div style="text-align:center;"><?php echo $Msg;?></div>
<?php } ?>
<?php
require_once('../include/footer.php');
?>
</div>
</body>
</html>
