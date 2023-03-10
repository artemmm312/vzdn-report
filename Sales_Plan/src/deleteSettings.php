<?php

$file_name = '';

if (!empty($_POST['file_name'])) {
	$file_name = $_POST['file_name'];
	$reg = "/[^а-яА-ЯёЁa-zA-Z0-9_ ]/u";
	if (!preg_match($reg, $file_name)) {
		unlink(dirname(__DIR__) . "/settings/saved/$file_name.json");
		echo 'Файл удалён.';
	} else {
		echo 'Не верное имя файла.';
	}
}
