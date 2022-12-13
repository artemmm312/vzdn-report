<?php

$file_name = '';

if (!empty($_POST['file_name'])) {
	$file_name = $_POST['file_name'];
	$reg = "/[!@#$%^&*()_?<>]/g";
	preg_replace($reg, '', $file_name);
}
if ($file_name !== '') {
	$file = dirname(__DIR__) . "/settings/saved/$file_name.json";
} else {
	$file = dirname(__DIR__) . "/settings/lastSettings.json";
}
header('Content-Type: application/json');
readfile($file, false);
