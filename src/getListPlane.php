<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php"); ?>

<?php

$dir = '../settings/saved';
$scanned_directory = array_diff(scandir($dir), array('..', '.'));

global $USER;
$userId = $USER->GetID();

$top_user = '1';
$main_users = ['4', '5', '7'];
$main_of_group = ['14', '15'];
$one_group = ['10', '11', '12', '13', '17', '19'];

$result = [];
foreach ($scanned_directory as $file) {
	$data_file = json_decode(file_get_contents("../settings/saved/" . $file), true);
	switch ($data_file[0]['type_of_plane']) {
		case 'Общий':
			$result[] = $file;
			break;
		case 'По пользователям':
			if ($userId === $top_user || in_array($userId, $main_users, true)) {
				$result[] = $file;
			}
			if (in_array($userId, $main_of_group, true)) {
				foreach ($data_file[1] as $arr) {
					if ((int)$userId === $arr['id'] || in_array((string)$arr['id'], $one_group, true)) {
						$result[] = $file;
						break;
					}
				}
			}
			if (in_array($userId, $one_group, true)) {
				foreach ($data_file[1] as $arr) {
					if ((int)$userId === $arr['id']) {
						$result[] = $file;
					}
				}
			}
			break;
	}
}

echo json_encode(array_values($result));
