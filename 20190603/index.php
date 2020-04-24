<?php
require_once("../include/gpsvars.php");
include ("./lib/PHPQRcode/qrlib.php");
$data = "http://i4010.cse.ttu.edu.tw:9608/index.html";
if(!isset($data)) die("should set QRcode content.");
$PixelSize = 6;
$FrameSize = 6;
QRcode::png($data, false, QR_ECLEVEL_M, $PixelSize, $FrameSize, false);
?>