<?php
session_start();
if(!empty($_SESSION['LoginID'])){
    $ID = $_SESSION['LoginID'];
} else {
    echo "<meta http-equiv=REFRESH CONTENT=1;url=login.php>";
    exit();
}
// Authentication 認證
// login 一致，建一個 user:tlpao 密碼的注音 au4a83
// 上傳 excel, 下載通訊錄 excel 
require_once("../include/auth.php");
// session_start();
// 變數及函式處理，請注意其順序
require_once("../include/gpsvars.php");
require_once("../include/configure.php");
require_once("../include/db_func.php");
$db_conn = connect2db($dbhost, $dbuser, $dbpwd, $dbname);
/*
$sqlcmd = "SELECT * FROM user WHERE loginid='$LoginID' AND valid='Y'";
$rs = querydb($sqlcmd, $db_conn);
if (count($rs) <= 0) die ('Unknown or invalid user!');
$UserGroupID = $rs[0]['groupid'];
// var_dump($_SESSION);
// 取出群組資料
$sqlcmd = "SELECT * FROM groups WHERE valid='Y' AND (groupid='$UserGroupID' "
    . "OR groupid IN (SELECT groupid FROM userpriv "
    . "WHERE loginid='$LoginID' AND privilege > 1 AND valid='Y'))";
$rs = querydb($sqlcmd, $db_conn);
if (count($rs)<=0) die('No group could be found!');  
$GroupNames = array();
foreach ($rs as $item) {
    $ID = $item['groupid'];
    $GroupNames[$ID] = $item['groupname'];
}
*/

if (isset($action) && $action=='recover' && isset($cid)) {
    // Recover this item
    // Check whether this user have the right to modify this contact info
    $sqlcmd = "SELECT * FROM namelist WHERE cid='$cid' AND valid='N'";
    $rs = querydb($sqlcmd, $db_conn);
    if (count($rs) > 0) {
//        $GID = $rs[0]['groupid'];
//        if (isset($GroupNames[$GID])) {     // Yes, the  user has the right. Perform update
            $sqlcmd = "UPDATE namelist SET valid='Y' WHERE cid='$cid'";
            $result = updatedb($sqlcmd, $db_conn);
//        }
    }
}

if (isset($action) && $action == 'delete' && isset($cid)) {
    // Invalid this item
    // Check whether this user have the right to modify this contact info
    $sqlcmd = "SELECT * FROM namelist WHERE cid='$cid' AND valid='Y'";
    $rs = querydb($sqlcmd, $db_conn);
    if (count($rs) > 0) {
//        $GID = $rs[0]['groupid'];
//        if (isset($GroupNames[$GID])) {     // Yes, the user has the right. Perform update
            $sqlcmd = "UPDATE namelist SET valid='N' WHERE cid='$cid'";
            $result = updatedb($sqlcmd, $db_conn);
//        }
    }
}
$ItemPerPage = 5;
$PageTitle = '單位人員資訊系統示範';
require_once("../include/header.php");
/*
$GroupIDs = '';
foreach ($GroupNames as $ID => $GroupName) $GroupIDs .= "','" . $ID;
$GroupIDs = "(" . substr($GroupIDs,2) . "')";
$sqlcmd = "SELECT count(*) AS reccount FROM namelist WHERE groupid IN $GroupIDs ";
*/
$sqlcmd = "SELECT count(*) AS reccount FROM namelist ";
$rs = querydb($sqlcmd, $db_conn);
$RecCount = $rs[0]['reccount'];
$TotalPage = (int) ceil($RecCount/$ItemPerPage);
if (!isset($Page)) {
    if (isset($_SESSION['CurPage'])) $Page = $_SESSION['CurPage'];
    else $Page = 1;
}
if ($Page > $TotalPage) $Page = $TotalPage;
$_SESSION['CurPage'] = $Page;
$StartRec = ($Page-1) * $ItemPerPage;
$sqlcmd = "SELECT * FROM namelist "
    . "LIMIT $StartRec,$ItemPerPage";
$Contacts = querydb($sqlcmd, $db_conn);
?>

<Script Language="JavaScript">
<!--
function confirmation(DspMsg, PassArg) {
var name = confirm(DspMsg)
    if (name == true) {
      location=PassArg;
    }
}
-->
</SCRIPT>
<div id="logo">單位人員名冊</div>
<table border="0" width="90%" align="center" cellspacing="0"
  cellpadding="2">
<tr>
  <td width="50%" align="left">
<?php if ($TotalPage > 1) { ?>
<form name="SelPage" method="POST" action="">
  第<select name="Page" onchange="submit();">
<?php 
for ($p=1; $p<=$TotalPage; $p++) { 
    echo '  <option value="' . $p . '"';
    if ($p == $Page) echo ' selected';
    echo ">$p</option>\n";
}
?>
  </select>頁 共<?php echo $TotalPage ?>頁
</form>
<?php } ?>
  <td>
  <td align="right" width="30%">
    <a href="excelexport.php">下載 excel</a>&nbsp;
    <a href="excelupload.php">上傳 excel</a>&nbsp;
    <a href="contactadd.php">新增</a>&nbsp;
    <a href="logout.php">登出</a>
  </td>
</tr>
</table>
<table class="mistab" width="90%" align="center">
<tr>
  <th width="15%">處理</th>
  <th width="10%">姓名</th>
  <th width="20%">電話</th>
  <th width="15%">生日</th>
  <th width="20%">地址</th>
  <th width="10%">單位</th>
  <th>照片</th>
</tr>
<?php
foreach ($Contacts AS $item) {
  $cid = $item['cid'];
  $Name = $item['name'];
  $Phone = $item['phone'];
  $Address = $item['address'];
  $Birthday = $item['birthday'];
  $GroupID = $item['groupid'];
  $Valid = $item['valid'];
    
//  $GroupName = '&nbsp;';
//  if (isset($GroupNames[$GroupID])) $GroupName = $GroupNames[$GroupID];
  $DspMsg = "'確定刪除項目?'";
  $PassArg = "'contactmgm.php?action=delete&cid=$cid'";
  echo '<tr align="center"><td>';
  if ($Valid=='N') {
    ?>
      <a href="contactmgm.php?action=recover&cid=<?php echo $cid; ?>">
        <img src="../images/recover.gif" border="0" align="absmiddle">
        </a></td>
      <td><STRIKE><?php echo $Name ?></STRIKE></td>
    <?php } else { ?>
    <?php
      if($DspMsg == "'確定刪除項目?'") {
            $action = 'delete';
      }
  ?>
  <!--<a href="javascript:confirmation(<?php //echo $DspMsg ?>, <?php //echo $PassArg ?>)">-->
  
  <a href="javascript:confirmation(<?php echo $DspMsg ?>, <?php echo $PassArg ?>)">
  <img src="../images/void.gif" border="0" align="absmiddle" alt="按此鈕將本項目作廢"></a>&nbsp;
  
  <a href="contactmod.php?cid=<?php echo $cid; ?>">
  <img src="../images/edit.gif" border="0" align="absmiddle"
    alt="按此鈕修改本項目"></a><br>
    <a href="upload.php?cid=<?php echo $cid; ?>">上傳圖片</a>&nbsp;
  </td>
  <td><?php echo $Name ?></td>   
<?php } ?>
  <td><?php echo $Phone ?></td>
  <td><?php echo $Birthday ?></td>
  <td><?php echo xssfix($Address) ?></td>
  <td><?php echo $GroupID ?></td>
  <td><?php 

      $sqlcmd_search = "SELECT * FROM photo WHERE cid='$cid' AND Valid = 'Y'";
      //$sqlcmd = "SELECT * FROM photo WHERE cid='$ID' AND Valid = 'Y'"
      $rs_search = querydb($sqlcmd_search, $db_conn);
      //if(count($rs_search) != 0) echo $rs_search[0]['photo'];
      if (count($rs_search) > 0) {
        //$output = fread($fp, filesize($filename));
        //$output = $rs_search[0]['photo'];
        //echo $output;
        $output = $rs_search[0]['photo'];  
        echo '<img src="data:image/jpeg;base64,'.base64_encode( $output ).'" width="140" height="140"/>';

      }
      else {
          ?>
          <img src="./no_image.jpg" width="140">
          <?php
      };
      ?></td>        
  </tr>
<?php
}
?>
</table>
</div>
</body>
</html>