<?php if (!empty($ErrMsg)) { ?>
<Script Language="JavaScript">
<!--
  alert('<?php echo $ErrMsg; ?>');
-->
</Script>
<?php } ?>

<html>
<head>
    <style>
	    #footer{
			position: absolute;/*←絕對位置*/
			bottom: 0; /*固定在下方*/
			width:95%;
			text-align: center;
			padding: 10px 0;
		}
	</style>
</head>

<body>
	<div id="footer">
		<b>網頁程式設計與安全實務</b>
	</div>
</body>
</html>