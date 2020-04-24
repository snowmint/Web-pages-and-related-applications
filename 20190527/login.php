<?php
function userauth($ID, $PWD, $db_conn) {
    $sqlcmd = "SELECT * FROM user WHERE loginid='$ID' AND valid='Y'";
    $rs = querydb($sqlcmd, $db_conn);
    $retcode = 0;
    if (count($rs) > 0) {
        $Password = sha1($PWD);
        if ($Password == $rs[0]['passwd']) $retcode = 1;
    }
    return $retcode;
}
session_start();
session_unset();
require_once("../include/gpsvars.php");
require ("../include/configure.php");
require ("../include/db_func.php");
$db_conn = connect2db($dbhost, $dbuser, $dbpwd, $dbname);
$ErrMsg = "";
if (!isset($ID)) $ID = "";
if (isset($Submit)) {
    if (strlen($ID) > 0 && strlen($ID)<=16 && $ID==addslashes($ID)) {
        $Authorized = userauth($ID,$PWD,$db_conn);
		if ($Authorized) {
		    $sqlcmd = "SELECT * FROM user WHERE loginid='$ID' AND valid='Y'";
		    $rs = querydb($sqlcmd, $db_conn);
			$LoginID = $rs[0]['loginid'];
	        $_SESSION['LoginID'] = $LoginID;
            header ("Location: ./Authenticator/index.php");
            //header ("Location: contactmgm.php");
            exit();
		}
		$ErrMsg = '<font color="Red">'
			. '您並非合法使用者或是使用權已被停止</font>';
    } else {
		$ErrMsg = '<font color="Red">'
			. 'ID錯誤，您並非合法使用者或是使用權已被停止</font>';
	}
  if (empty($ErrMsg)) $ErrMsg = '<font color="Red">登入錯誤</font>';
}
?>
<HTML>
<HEAD>
<meta HTTP-EQUIV="Content-Type" content="text/html; charset=big5">
<meta HTTP-EQUIV="Expires" CONTENT="Tue, 01 Jan 1980 1:00:00 GMT">
<meta HTTP-EQUIV="Pragma" CONTENT="no-cache">
<title>登錄系統</title>
<style type="text/css">
<!--
body {font-family: 新細明體, arial; font-size: 12pt; color: #000000}
pre, tt {font-size: 12pt}
th {font-family: 新細明體, arial; font-size: 12pt; font-weight: bold; background-color: #F0E68C}
td {font-family: 新細明體, arial; font-size: 12pt;}
form {font-family: 新細明體, arial; font-size: 12pt;}
input {font-family: 新細明體, arial; font-size: 12pt; color: #000000}
input.pwdtext {font-family: helvetica, sans-serif;}
a:active{color:#FF0000; text-decoration: none}
a:link{color:#0000FF; text-decoration: none}
a:visited{color:#0000FF; text-decoration: none}
a:hover{color:#FF0000; text-decoration: none}
//-->
</style>
</HEAD>
<script type="text/javascript">
<!--
function setFocus()
{
<?php if (empty($ID)) { ?>
    document.LoginForm.ID.focus();
<?php } else { ?>
    document.LoginForm.PWD.focus();
<?php } ?>
}
//-->
</script>
<center>
<BODY bgcolor="#FFFFCC" text="#000000"
  topmargin="0" leftmargin="0" rightmargin="0" onload="setFocus()">
<table width="600" border="0" cellspacing="0" cellpadding="0" align="center">
<tr><td align="center">
請於輸入框中輸入帳號與密碼，然後按「登入」按鈕登入。
</td></tr>
<tr><td>&nbsp;</td></tr>
<tr>
  <td>
  <form method="POST" name="LoginForm" action="">
  <table width="300" border="1" cellspacing="0" cellpadding="2"
    align="center" bordercolor="Blue">
  <tr bgcolor="#FFCC33" height="35">
    <td align="center">登入系統
    </td>
  </tr>
  <tr bgcolor="#FFFFCC" height="35">
    <td align="center">帳號：
      <input type="text" name="ID" size="16" maxlength="16"
        value="<?php echo $ID; ?>" class="pwdtext">
    </td>
  </tr>
  <tr bgcolor="#FFFFCC" height="35">
    <td align="center">密碼：
      <input type="password" name="PWD" size="16" maxlength="16" class="pwdtext">
    </td>
  </tr>
  <tr bgcolor="#FFCC33" height="35">
    <td align="center">
      <input type="submit" name="Submit" value="登入">
    </td>
  </tr>
  </table>
  </form>
  </td>
</tr>
</table>
<?php if (!empty($ErrMsg)) echo $ErrMsg; ?>
</body>
</html>