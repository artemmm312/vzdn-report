<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php"); ?>

<?php
\Bitrix\Main\Loader::includeModule('crm');

$fd = fopen("../settings/lastSettings.json", 'r') or die("не удалось открыть файл");
$settings = null;
while (!feof($fd)) {
	$settings = json_decode(fgets($fd), true);
}
fclose($fd);

$general_settings = $settings[0];
$first_date = null;
$last_date = null;
switch ($general_settings['season']) {
	case "Месяц":
		$month_start = $general_settings['month_or_quarter'] + 1;
		$month_end = $general_settings['month_or_quarter'] + 2;
		$year = $general_settings['year'];
		if ($general_settings['month_or_quarter'] === 11) {
			$month_end = 1;
			$year = $general_settings['year'] + 1;
		}
		$first_date = date("d.m.Y", mktime(0, 0, 0, $month_start, 1, $general_settings['year']));
		$last_date = date("d.m.Y", mktime(0, 0, 0, $month_end, 1, $year));
		break;
	case "Квартал":
		$month_start = ['0' => 1, '1' => 4, '2' => 7, '3' => 10];
		$month_end = ['0' => 4, '1' => 7, '2' => 10, '3' => 1];
		$year = $general_settings['year'];
		if ($general_settings['month_or_quarter'] === '3') {
			$year = $general_settings['year'] + 1;
		}
		$first_date = date("d.m.Y", mktime(0, 0, 0, $month_start[$general_settings['month_or_quarter']], 1, $general_settings['year']));
		$last_date = date("d.m.Y", mktime(0, 0, 0, $month_end[$general_settings['month_or_quarter']], 1, $year));
		break;
	case "Год":
		$month = 1;
		$year = $general_settings['year'] + 1;
		$first_date = date("d.m.Y", mktime(0, 0, 0, $month, 1, $general_settings['year']));
		$last_date = date("d.m.Y", mktime(0, 0, 0, $month, 1, $year));
		break;
}

$filter = null;
if ($general_settings['type_of_plane'] === 'Общий') {
	$filter = ['CATEGORY_ID' => 0, 'STAGE_ID' => 'WON', '>=CLOSEDATE' => $first_date, '<CLOSEDATE' => $last_date, 'CHECK_PERMISSIONS' => 'N'];
} elseif ($general_settings['type_of_plane'] === 'По пользователям') {
	$users_plane = $settings[1];
	$usersID = [];
	foreach ($users_plane as $key) {
		$usersID[] = $key['id'];
	}
	$filter = ['CATEGORY_ID' => 0, 'ASSIGNED_BY_ID' => $usersID, 'STAGE_ID' => 'WON', '>=CLOSEDATE' => $first_date, '<CLOSEDATE' => $last_date, 'CHECK_PERMISSIONS' => 'N'];
}

$Deals = CCrmDeal::GetListEx([], $filter, false, false, []);
$data_deals = [];
while ($record = $Deals->Fetch()) {
	$data_products = [];
	$products = CCrmDeal::LoadProductRows($record['ID']);
	foreach ($products as $product) {
		$ins_product = CCrmProduct::GetByID($product['PRODUCT_ID']);
		$data_products[] = ['PRODUCT_ID' => $product['PRODUCT_ID'],
			'QUANTITY' => $product['QUANTITY'],
			'CATALOG_ID' => $ins_product['CATALOG_ID'],
			'SECTION_ID' => $ins_product['SECTION_ID']];
	}
	$data_deals[$record['ASSIGNED_BY_ID']][] =
		[
			'ID' => $record['ID'],
			'STAGE_ID' => $record['STAGE_ID'],
			'NAME' => "{$record['ASSIGNED_BY_NAME']} {$record['ASSIGNED_BY_LAST_NAME']}",
			'OPPORTUNITY' => $record['OPPORTUNITY'],
			'ASSIGNED_BY_ID' => $record['ASSIGNED_BY_ID'],
			'CLOSEDATE' => $record['CLOSEDATE'],
			'PRODUCTS' => $data_products
		];
}


//var_dump($data_deals);
/*global $USER;
$userId = $USER->GetID();


$result = array_filter($data_deals,
	function($key) use($userId) {
	$top_user = 1;
	$main_users = [4, 5, 7];
	$main_of_group = [14, 15];
	$one_group = [10, 11, 12, 13, 17, 19];
	if($userId === $top_user || in_array($userId, $main_users)) {
		return $key;
	}
	if(in_array($userId, $main_of_group)) {
		if($key === $userId || in_array($key, $one_group)) {
			return $key;
		}
	}
	if(in_array($userId, $one_group)) {
		if(in_array($key, $one_group)) {
			return $key;
		}
	}
}, ARRAY_FILTER_USE_KEY);
//var_dump($result);
echo json_encode($result);*/
echo json_encode($data_deals);

