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
require_once ("../Classes/PHPExcel/IOFactory.php");

function xss_clean($data)
{
    // Fix &entity\n;
    $data = str_replace(array('&amp;','&lt;','&gt;'), array('&amp;amp;','&amp;lt;','&amp;gt;'), $data);
    $data = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $data);
    $data = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $data);
    $data = html_entity_decode($data, ENT_COMPAT, 'UTF-8');

    // Remove any attribute starting with "on" or xmlns
    $data = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $data);

    // Remove javascript: and vbscript: protocols
    $data = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $data);
    $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $data);
    $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $data);

    // Only works in IE: <span style="width: expression(alert('Ping!'));"></span>
    $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
    $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
    $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $data);

    // Remove namespaced elements (we do not need them)
    $data = preg_replace('#</*\w+:\w[^>]*+>#i', '', $data);

    do
    {
        // Remove really unwanted tags
        $old_data = $data;
        $data = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $data);
    }
    while ($old_data !== $data);

    // we are done...
    return $data;
}

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
        //cid auto increament
        //第一列(欄位A~E)： name | groupid | phone | address | valid
        if ($sheetData[1]['A'] <> 'name')    { $ErrMsg .= '欄位A1應為「name」\n'; }
        if ($sheetData[1]['B'] <> 'groupid') { $ErrMsg .= '欄位B1應為「groupid」\n'; }
        if ($sheetData[1]['C'] <> 'birthday') { $ErrMsg .= '欄位C1應為「birthday」\n'; }
        if ($sheetData[1]['D'] <> 'phone')   { $ErrMsg .= '欄位D1應為「phone」\n'; }
        if ($sheetData[1]['E'] <> 'address') { $ErrMsg .= '欄位E1應為「address」\n'; }
        if ($sheetData[1]['F'] <> 'valid')   { $ErrMsg .= '欄位F1應為「valid」\n'; }
        
        if(!empty($ErrMsg)) $sheetData = array();
        $SqlcmdPrefix = 'INSERT INTO namelist (name,groupid,birthday,phone,address,valid) VALUES (';
        for ($Row=2; $Row<=count($sheetData) && empty($ErrMsg); $Row++) {
            $TotalPeocessing++;
            //$KeySeed = 'A' . $ThisYear . $myuCode.$sheetData[$Row]['A'];
            //$AccessKey = strtoupper(sha1($KeySeed));
			//$password = substr($AccessKey,10,8);
			//$student_id = $sheetData[$Row]['A'];
            
            $name = $sheetData[$Row]['A'];
            $name = addslashes(xss_clean($name));
            $groupid = $sheetData[$Row]['B'];
            $groupid = addslashes(xss_clean($groupid));
            $birthday = $sheetData[$Row]['C'];
            //$birthday = addslashes(xss_filter($birthday));
            $phone = $sheetData[$Row]['D'];
            $phone = addslashes(xss_clean($phone));
            $address = $sheetData[$Row]['E'];
            $address = addslashes(xss_clean($address));
            $valid = $sheetData[$Row]['F'];
            $valid = addslashes(xss_clean($valid));
            
            $sqlcmd = "SELECT * FROM namelist WHERE name='$name' AND birthday='$birthday'"
                . "AND groupid='$groupid' AND phone='$phone' AND address='$address' ";
            
            $rs = querydb($sqlcmd, $db_conn);
            if (count($rs) > 0) {
                $UpdateCount++;
                $RecID = $rs[0]['cid'];
				$sqlcmd = "UPDATE namelist SET name='$name',groupid='$groupid', birthday='$birthday',"
                    . "phone='$phone', address='$address',valid='$valid'  WHERE cid='$RecID'";
            } else {
                $sqlcmd = $SqlcmdPrefix . "'$name','$groupid','$birthday','$phone',"
                    . "'$address','$valid')";
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
$ThisPageTitle = '學生資料上傳';
?>
<body>
<div class="Outerbox">
<?php //require_once('topmenu.php'); ?>
<table width="720" align="center" border="0">
    <tr>
        <td>
            請選擇檔案，然後點選上傳檔案按鈕，即可將學生資料上傳至系統中，
            上傳的檔案大小以2MBytes為限。
        </td>
    </tr>
    <tr>
        <td>
            檔案格式：Excel檔<br />
            第一列(欄位A~F)： name | groupid | birthday | phone | address | valid<br />
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
    <input action="action" type="button" onclick="window.location.replace('./contactmgm.php');" value="回到通訊錄">
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
