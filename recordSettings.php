<?php

$data = $_POST['settings'];
var_dump($data);

$filename = "settings/lastSettings.json";

$fd = fopen($filename, 'w') or die("не удалось открыть файл");
fwrite($fd, $data);
fclose($fd);
