<?php
    require_once('../include/header.php');
    require_once('../include/configure.php');
    require_once('../include/db_func.php');
	$db_conn = connect2db($dbhost, $dbuser, $dbpwd, $dbname);
	$splcmd = "SELECT * FROM contact";
	$rs = querydb($splcmd, $db_conn);
	$arrGender = array('M'=>'男', 'F'=>'女', 'X'=>'NA');
?>
<html>
<head>
</head>
<body>
	<div style="margin:30px 30px;">
	<table align="center" class="mystyle">
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