<?php

$dir  = dirname(__DIR__) . "/settings/saved";
$scanned_directory = array_diff(scandir($dir), array('..', '.'));
header('Content-Type: application/json');
echo json_encode($scanned_directory);
