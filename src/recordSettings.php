<?php

$settings = $_POST['settings'];

$file_name = '';

if(!empty($_POST['file_name'])) {
	$file_name = $_POST['file_name'];
	$reg = "/[^а-яА-ЯёЁa-zA-Z0-9_ ]/u";
	if(!preg_match($reg, $file_name)) {
		$file = dirname(__DIR__) . "/settings/saved/$file_name.json";
		file_put_contents($file, $settings);
		echo 'Файл сохранён.';
	} else {
		echo 'Не верное имя файла.';
	}
} else {
	$file = dirname(__DIR__) . "/settings/lastSettings.json";
	file_put_contents($file, $settings);
}
