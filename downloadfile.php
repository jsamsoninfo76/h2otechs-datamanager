<?php

$dir = (isset($_GET['dir'])) ? $_GET['dir'] : "";
$filename = (isset($_GET['filename'])) ? $_GET['filename'] : "";

if ($filename != "" && $dir != ""){
	$url = "upload/" .$dir. "/" .$filename;
	header('Content-Description: File Transfer');
	header('Content-Type: application/octet-stream');
	header('Content-Disposition: attachment; filename="'. basename($url) .'";');
	@readfile($url) OR die();
}
?>