<?php

$file_name = '';

if(!empty($_POST['file_name'])) {
	$file_name = $_POST['file_name'];
	$reg = "/[!@#$%^&*()_?<>]/g";
	preg_replace($reg, '', $file_name);
}

if($file_name !== '') {
	unlink("../settings/saved/$file_name.json");
}
