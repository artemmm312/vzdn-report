<?php

$fd = fopen("settings/lastSettings.json", 'r') or die("не удалось открыть файл");
$response = null;
while (!feof($fd)) {
	$response = fgets($fd);
}
fclose($fd);

echo $response;
