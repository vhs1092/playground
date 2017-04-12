<?php
	include("../../js/phpqrcode/qrlib.php");
	$qr=$_GET['qr'];
	QRcode::png($qr);
?>