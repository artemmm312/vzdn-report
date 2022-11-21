<?php

$settings = $_POST['settings'];

$file_name = '';

if(!empty($_POST['file_name'])) {
	$file_name = $_POST['file_name'];
}
if($file_name !== '') {
	$file = "../settings/saved/$file_name.json";
} else {
	$file = "../settings/lastSettings.json";
}
$fd = fopen($file, 'w') or die("не удалось открыть файл");
fwrite($fd, $settings);
fclose($fd);
