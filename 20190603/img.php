<?php
    require_once("../include/configure.php");
    require_once("../include/gpsvars.php");
    require_once("../include/db_func.php");
    $db_conn = connect2db($dbhost, $dbuser, $dbpwd, $dbname);
    $ID = $_GET['ID'];
    if (!isset($ID)) exit;

    $filetype = 'image/jpeg';
    $sqlcmd = "SELECT * FROM photo WHERE cid='$ID' AND Valid = 'Y'"
    $rs = querydb($sqlcmd, $db_conn);
    $filename = $rs[0]['filename'];
    if (count($rs) > 0) {
        header("Content-type: $filetype ");
        header("Content-Disposition: filename=$filename");
        $output = $rs[0]['photo'];
        echo $output;
    }
?>