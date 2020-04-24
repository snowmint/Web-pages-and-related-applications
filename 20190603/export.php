<?php
header("Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet \n");
header("Content-Disposition: filename=export.xlsx \n");
//header("Content-type:application/vnd.ms-excel");
//header("Content-Disposition:filename=export.xlsx");
require_once ("../include/gpsvars.php") ;
require_once ("../include/configure.php") ; 
require_once ("../include/db_func.php") ;
require_once ("../Classes/PHPExcel/IOFactory.php");

$db_conn = connect2db($dbhost, $dbuser, $dbpwd, $dbname);
//$select = mysql_select_db("destoon",$conn); 
//mysql_query("SET character_set_connection='gbk', character_set_results='gbk', character_set_client=binary");
$sqlcmd = "SELECT * FROM namelist Order by cid";
$rs = querydb($sqlcmd, $db_conn);

//name | groupid | birthday | phone | address | valid
echo "cid\tname\tgroupid\tbirthday\tphone\taddress\tvalid\t";
$query_count = querydb($sqlcmd,$db_conn);
while ($array = $query_count->fetch(PDO::FETCH_ASSOC)){//$row = $stmt->fetch(PDO::FETCH_ASSOC)
    echo $array['cid']."\t"; 
    echo $array['name']."\t"; 
    echo $array['groupid']."\t"; 
    echo date("H:i:s",$array['birthday'])."\t"; 
    echo $array['phone']."\t"; 
    echo $array['address']."\t"; 
    echo $array['valid']."\t";
    echo "\n"; 

} 
?> 