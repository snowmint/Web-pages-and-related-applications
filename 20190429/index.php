<?php
    require_once('../include/header.php');
    require_once('../include/gpsvars.php');
    require_once('../include/configure.php');
    require_once('../include/db_func.php');
	$db_conn = connect2db($dbhost, $dbuser, $dbpwd, $dbname);
	$splcmd = "SELECT * FROM contact";
	$rs = querydb($splcmd, $db_conn);
	$arrGender = array('M'=>'男', 'F'=>'女', 'X'=>'NA');
?>
<html>
<head>
	<style>
	body{
		background-image: linear-gradient(to top, #fff1eb 0%, #ace0f9 100%);
	}
	table {
	  border-collapse: collapse;
	  border: solid 3px #8cb8ff;/*表全体を線で囲う*/
	  width:300px;
	  background: #ffffff;/*背景色*/
	  
	}
	table th, table td {
	  border: dashed 1px #8cb8ff;/**/
	  /*破線 1px 青色*/
	  height: 30px;
	}
	table th{
		color: #639cff;/*文字色*/
		background: #d1e2ff;/*背景色*/
	}
	table td{
		color:#848484;
	}
	</style>
</head>
<body>
	<div style="margin:30px 30px;">
	<table align="center">
		<tr>
			<th width="160">Name</th>
			<th width="160">Gender</th>
			<th width="160">Birthday</th>
		</tr>
		<?php
			foreach($rs as $item){
				$curName = $item['name'];
				$Gender = $item['gender'];
				if(isset($arrGender[$Gender])) {
					$Gender = $arrGender[$Gender];
				}
				$Birthday = $item['birthday'];
			?>
			<tr align="center">
				<td><?php echo $curName; ?></td>
				<td><?php echo $Gender; ?></td>
				<td><?php echo $Birthday; ?></td>
			</tr>
		<?php } ?>
	</table>
	<br>
	<?php
		require_once('../include/footer.php');
	?>
</body>
</html>