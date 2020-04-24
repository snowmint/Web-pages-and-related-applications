<?php
// Authentication 認證
// require_once("../include/auth.php");
// session_start();
// 變數及函式處理，請注意其順序
require_once("../include/gpsvars.php");
require_once("../include/configure.php");
require_once("../include/db_func.php");
$db_conn = connect2db($dbhost, $dbuser, $dbpwd, $dbname);

if (isset($action) && $action=='recover' && isset($cid)) {
    // Recover this item
    // Check whether this user have the right to modify this contact info
    $sqlcmd = "SELECT * FROM namelist WHERE cid='$cid' AND valid='N'";
    $rs = querydb($sqlcmd, $db_conn);
    if (count($rs) > 0) {
            $sqlcmd = "UPDATE namelist SET valid='Y' WHERE cid='$cid'";
            $result = updatedb($sqlcmd, $db_conn);
    }
}
if (isset($action) && $action=='delete' && isset($cid)) {
    // Invalid this item
    // Check whether this user have the right to modify this contact info
    $sqlcmd = "SELECT * FROM namelist WHERE cid='$cid' AND valid='Y'";
    $rs = querydb($sqlcmd, $db_conn);
    if (count($rs) > 0) {
            $sqlcmd = "UPDATE namelist SET valid='N' WHERE cid='$cid'";
            $result = updatedb($sqlcmd, $db_conn);
    }
}
$ItemPerPage = 5;
$PageTitle = '單位人員資訊系統示範';
require_once("../include/header.php");

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
</Script>
<div>
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
            <a href="contactadd.php">新增</a>&nbsp;
            <a href="/i4010/logout.php">登出</a>
          </td>
      </tr>
  </table>
  <table class="mistab" width="90%" align="center">
  <tr>
    <th width="15%">處理</th>
    <th width="15%">姓名</th>
    <th width="20%">電話</th>
    <th>地址</th>
    <th width="20%">單位</th>
  </tr>
  <?php
  foreach ($Contacts AS $item) {
    $cid = $item['cid'];
    $Name = $item['name'];
    $Phone = $item['phone'];
    $Address = $item['address'];
    $GroupID = $item['groupid'];
    $Valid = $item['valid'];
    $DspMsg = "'確定刪除項目?'";
    $PassArg = "'contactlist.php?action=delete&cid=$cid'";
    echo '<tr align="center"><td>';
    if ($Valid=='N') {
  ?>
  <tr>
    <td><a href="contactlist.php?action=recover&cid=<?php echo $cid; ?>">
        <img src="../images/recover.gif" border="0" align="absmiddle">
        </a></td>
    <td><STRIKE><?php echo $Name ?></STRIKE></td>
    <?php } else { ?>
    <td><a href="javascript:confirmation(<?php echo $DspMsg ?>, <?php echo $PassArg ?>)">
        <img src="../images/void.gif" border="0" align="absmiddle"
          alt="按此鈕將本項目作廢"></a>&nbsp;
        <a href="contactmod.php?cid=<?php echo $cid; ?>">
        <img src="../images/edit.gif" border="0" align="absmiddle"
          alt="按此鈕修改本項目"></a>&nbsp;
    </td>
    <td><?php echo $Name ?></td>   
    <?php } ?>
    <td><?php echo $Phone ?></td>  
    <td><?php echo xssfix($Address) ?></td>
    <td><?php echo $GroupID ?></td>        
  </tr>
  <?php
  }
  print_r($_SESSION);
  ?>
  </table>
</div>
