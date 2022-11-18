<?php

/*$fd = fopen("settings/lastSettings.json", 'r') or die("не удалось открыть файл");
$response = null;
while (!feof($fd)) {
	$response = fgets($fd);
}
fclose($fd);

echo $response;*/
$file_name = '';
if(!empty($_POST['file_name'])) {
	$file_name = $_POST['file_name'];
}
if($file_name !== '') {
	$file = "settings/saved/$file_name.json";
} else {
	$file = "settings/lastSettings.json";
}

readfile ($file,false);
