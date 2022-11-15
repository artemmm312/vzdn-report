<?php

$data = $_POST['settings'];

$filename = "settings/lastSettings.json";

$fd = fopen($filename, 'w') or die("не удалось открыть файл");
fwrite($fd, $data);
fclose($fd);
