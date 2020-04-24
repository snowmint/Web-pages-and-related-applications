<?php
if (isset($_POST['Abort'])) {
    header("Location: contactmgm.php");
    exit();
}
// Authentication 認證// upload = ON // limit檔案最大20MB//post_max_size = 28M// 上傳 excel 檔會被展開：Memoey_limit = 512MB

//test
$cid = $_GET['cid'];

require_once("../include/auth.php");
// 變數及函式處理，請注意其順序
require_once("../include/gpsvars.php");
require_once("../include/configure.php");
require_once("../include/db_func.php");
//require_once("../include/aux_func.php");
$db_conn = connect2db($dbhost, $dbuser, $dbpwd, $dbname);

if (isset($GoUpload) && $GoUpload=='1') {
    $cid = $_GET['cid'];
    $fname = $_FILES["userfile"]['name'];
    $ftype = $_FILES["userfile"]['type'];
    if ($_POST["fname"] <> $_POST["orgfn"]) $fname = $_POST["fname"];
    $fsize = $_FILES['userfile']['size'];
    if (!empty($fname) && addslashes($fname)==$fname && $fsize>0) {
        //echo strtolower($ftype);
        $db_conn = connect2db($dbhost, $dbuser, $dbpwd, $dbname);
        $sqlcmd_check = "SELECT * FROM photo WHERE cid='$cid'";
        $rs_check = querydb($sqlcmd_check, $db_conn);
        $file = $rs_check[0]['photo'];
        //echo $rs_check[0]['filename'];
        if(count($rs_check) > 0 && strtolower($ftype) == "image/jpeg") {
            $uploadfile = "$AttachDir/" . str_pad($cid,8,'0',STR_PAD_LEFT) . '.jpg';
            $fd = fopen($_FILES['userfile']['tmp_name'], 'rb');
            $image = fread($fd, $fsize);
            $image = addslashes($image);
            //$sqlcmd = "INSERT INTO photo (cid, photo, Valid) VALUES ('$cid', '$image',  'Y')";
            $sqlcmd = "UPDATE photo SET photo = '$image', filename = '$fname', filetype = '$ftype', Valid = 'Y' WHERE cid = '$cid'";
            $result = updatedb($sqlcmd, $db_conn);
        }else if(strtolower($ftype) == "image/jpeg"){
            $uploadfile = "$AttachDir/" . str_pad($cid,8,'0',STR_PAD_LEFT) . '.jpg';
            $fd = fopen($_FILES['userfile']['tmp_name'], 'rb');
            $image = fread($fd, $fsize);
            $image = addslashes($image);
            //$sqlcmd = "INSERT INTO photo (cid, photo, Valid) VALUES ('$cid', '$image',  'Y')";
            $sqlcmd = "INSERT INTO photo (cid, photo, filename, filetype, Valid) VALUES ('$cid', '$image', '$fname', '$ftype', 'Y')";
            $result = updatedb($sqlcmd, $db_conn);
            
            // 如果上傳的不是.jpg檔，怎麼辦！(自行思考對策)
            //move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile);
            //chmod ($uploadfile,0644); 
        }
        else {
            $ErrMsg = '請選擇 jpg 檔案！';
        }
    } else {
        $ErrMsg = '檔案不存在、大小為0或超過上限(100MBytes)';
    }
}
require_once("../include/header.php");

?>
<html>
    <head>
        <script language="JavaScript">
            <!--
            function startload() {
                var Ary = document.ULFile.userfile.value.split('\\');
                document.ULFile.fname.value=Ary[Ary.length-1];
                document.ULFile.orgfn.value=document.ULFile.userfile.value
                document.forms['ULFile'].submit();
                return true;
            }
            -->
        </script>
    </head>
    <body>
        <br>
        <form enctype="multipart/form-data" method="post" action="" name="ULFile">
            <table width="420" align="center" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td align="center">
                        <span style="font:12pt"><b>人員編號 <?php echo $cid ?> 附件檔案上傳</b></span>
                    </td>
                </tr>
            </table>

            <input type="hidden" name="MAX_FILE_SIZE" value="102497152">
            <input type="hidden" name="cid" value="<?php echo $cid ?>">
            <input type="hidden" name="GoUpload" value="1">
            <input type="hidden" name="fname">
            <input type="hidden" name="orgfn">
            <br>

            <table width="420" border="0" cellspacing="0" cellpadding="3" align="center">
                <tr>
                    <td align="center"> 上傳檔名：<input name="userfile" type="file"> </td>
                </tr>
                <tr>
                    <th>
                        <input type="button" name="upload" value="上傳照片" onclick="startload()">&nbsp;&nbsp;
                        <input type="submit" name="Abort" value="結束上傳">
                    </th>
                </tr>
            </table>
        </form>
        
        <?php
            $filetype = 'image/jpeg';
            $sqlcmd = "SELECT * FROM photo WHERE cid='$cid' AND Valid = 'Y'";
            $rs = querydb($sqlcmd, $db_conn);
            $file = $rs[0]['photo'];
            $Tag = date('His');
            if (count($rs) > 0) {
                ?>
                <br><br>
                <div align="center">原存影像<br><br>
                    <?php
                    echo '<img src="data:image/jpeg;base64,'.base64_encode( $file ).'" width="320"/>';
                    ?>
                </div>
                <?php
            }
            ?>
            <?php
            /*$filename = $AttachDir . '/' . str_pad($cid, 8, '0', STR_PAD_LEFT) . '.jpg';
            if (file_exists($filename)) {
                $Tag = date('His');
            ?>
                <br><br>
                <div align="center">原存影像<br><br>
                    <img src="getimagedb.php?ID=<?php echo $cid ?>&Tag=<?php echo $Tag ?>" border="0" width="320">
                </div>*/?>
            <?php
        require_once ("../include/footer.php");
        ?>
    </body>
</html>