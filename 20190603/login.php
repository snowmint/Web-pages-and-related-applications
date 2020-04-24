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
require_once("../include/gpsvars.php");
require_once ("../include/configure.php");
require_once ("../include/db_func.php");
require_once("../include/header.php");
$db_conn = connect2db($dbhost, $dbuser, $dbpwd, $dbname);

$ErrMsg = "";
//generate
$Chapcha = '';
if (empty($_SESSION['VerifyCode'])) {
    session_unset();
    $Seeds = '2345678abcdefhjkmnprstuvxyz';
    $Chapcha = '';
    for($i = 0; $i < 4; $i++) {
        $Chapcha .= substr($Seeds, rand(0, strlen($Seeds)-1), 1);
    }
    $_SESSION['VerifyCode'] = $Chapcha;
    //echo $_SESSION['VerifyCode'];
}

//if(!isset($_SESSION['VerifyCode'])) $_SESSION['VerifyCode'] = $Chapcha;
    
$varify = 0;
if (!isset($ID)) $ID = "";
if (isset($Submit)) {
    //echo $ID;
    if (isset($_SESSION['VerifyCode'])) {
        if($_SESSION['VerifyCode'] == $_POST['checkword']) {
            //$_SESSION['VerifyCode'] = ''; //比對正確後，清空將check_word值
            $varify = 1;
        }
        else {
            $varify = 0;
        }
        //echo $varify;
        if($varify == 1) {
            $sqlcmd = "SELECT * FROM user WHERE loginid='$ID' AND valid='Y'";
            $rs = querydb($sqlcmd, $db_conn);
            $LoginID = $rs[0]['loginid'];
            $_SESSION['LoginID'] = $LoginID;
            if($_SESSION['LoginID'] != "tlpao") header ("Location: ./Authenticator/index.php");
            else header ("Location: contactmgm.php");
            exit();
        } else {
            $ErrMsg = '<font color="Red">驗證碼錯誤</font>';
        }
    }
    else { $ErrMsg = '<font color="Red">請輸入驗證碼</font>'; }
    if (strlen($ID) > 0 && strlen($ID)<=16 && $ID==addslashes($ID)) {
        $Authorized = userauth($ID,$PWD,$db_conn);
		if ($Authorized && $varify == 1) {
		    $sqlcmd = "SELECT * FROM user WHERE loginid='$ID' AND valid='Y'";
		    $rs = querydb($sqlcmd, $db_conn);
			$LoginID = $rs[0]['loginid'];
	        $_SESSION['LoginID'] = $LoginID;
            header ("Location: ./Authenticator/index.php");
            //header ("Location: contactmgm.php");
            exit();
		}else if($varify == 1) {
            $ErrMsg = '<font color="Red">'
                . '您並非合法使用者或是使用權已被停止'.$_SESSION['VerifyCode'].','.$_POST['checkword'].')</font>';
        }
    } else {
		$ErrMsg = '<font color="Red">'
			. 'ID錯誤，您並非合法使用者或是使用權已被停止'.$_SESSION['VerifyCode'].','.$_POST['checkword'].')</font>';
	}
    if (empty($ErrMsg)) $ErrMsg = '<font color="Red">登入錯誤</font>';
    /*
    if (strlen($ID) > 0 && strlen($ID)<=16 && $ID==addslashes($ID)) {
        $Authorized = userauth($ID,$PWD,$db_conn);
		if ($Authorized && strlen($checkword) == 4) {
            if((!empty($_SESSION['VerifyCode'])) && (!empty($checkword))){  //判斷此兩個變數是否為空
                $varify = 0;
                if($_SESSION['VerifyCode'] == $checkword) {
                    $_SESSION['VerifyCode'] = ''; //比對正確後，清空將check_word值
                    $varify = 1;
                }
                else {
                    $varify = 0;
                }
                echo $varify;
                if($varify == 1) {
                    $sqlcmd = "SELECT * FROM user WHERE loginid='$ID' AND valid='Y'";
                    $rs = querydb($sqlcmd, $db_conn);
                    $LoginID = $rs[0]['loginid'];
                    $_SESSION['LoginID'] = $LoginID;
                    if($_SESSION['LoginID'] != "tlpao") header ("Location: ./Authenticator/index.php");
                    else header ("Location: contactmgm.php");
                    $varify = 0;
                    exit();
                } else {
                    $ErrMsg = '<font color="Red">('.$_SESSION['VerifyCode'].','.$checkword.' )</font>';
                }
            }else {
                $ErrMsg = '<font color="Red">錯誤('.$_SESSION['VerifyCode'].','.$checkword.' )</font>';
            }
        }
        else {
            $ErrMsg = '<font color="Red">'
                . '您並非合法使用者或是使用權已被停止</font>';
        }
    } else {
		$ErrMsg = '<font color="Red">'
			. 'ID錯誤，您並非合法使用者或是使用權已被停止</font>';
	}
  if (empty($ErrMsg)) $ErrMsg = '<font color="Red">登入錯誤</font>';*/
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
<tr><td align="center"><br>
請於輸入框中輸入帳號與密碼，然後按「登入」按鈕登入。
</td></tr>
<tr><td>&nbsp;</td></tr>
<tr>
  <td>
     <script>
        function refresh_code(){ 
            document.getElementById("imgcode").src="./images/chapcha.php"; 
        } 
    </script>
      <form method="POST" name="LoginForm" action="">
          <table width="300" border="1" cellspacing="0" cellpadding="2"
            align="center" bordercolor="#CCC">
          <tr bgcolor="#bfd6fc" height="35">
            <td align="center">登入系統
            </td>
          </tr>
          <tr bgcolor="#FFFFFF" height="55">
            <td align="center">帳號：
              <input type="text" name="ID" size="16" maxlength="16"
                value="<?php echo $ID; ?>" class="pwdtext">
            </td>
          </tr>
          <tr bgcolor="#FFFFFF" height="55">
            <td align="center">密碼：
              <input type="password" name="PWD" size="16" maxlength="16" class="pwdtext">
            </td>
          </tr>
          <tr bgcolor="#FFFFFF" height="45">
            <td align="center">
            <p style="margin-top:10px;">請輸入下圖字樣：</p>
               <img id="imgcode" src="./images/chapcha.php?VerifyCode=<?php echo $_SESSION['VerifyCode']?>" /><br>
               <?php echo '<font style="color:#FFFFCC;">'.$_SESSION['VerifyCode'].'</font>';?>
                <br>
              <input type="text" name="checkword" size="16" maxlength="4" class="pwdtext"><br><br>
            </td>
          </tr>
          <tr bgcolor="#bfd6fc" height="35">
            <td align="center">
              <input type="submit" name="Submit" value="登入">
            </td>
          </tr>
          </table>
      </form>
  </td>
</tr>
</table><br>
<?php if (!empty($ErrMsg)) echo $ErrMsg; ?>
</body>
</html>