<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php"); ?>

<?php
\Bitrix\Main\Loader::includeModule('crm');

$fd = fopen("settings/lastSettings.json", 'r') or die("не удалось открыть файл");
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
		$month_start = 1;
		$month_end = 12;
		$year = $general_settings['year'];
		$first_date = date("d.m.Y", mktime(0, 0, 0, $month_start, 1, $year));
		$last_date = date("d.m.Y", mktime(0, 0, 0, $month_end, 1, $year));
		break;
}

$users_settings = $settings[1];
$usersID = [];
foreach ($users_settings as $key) {
	$usersID[] = $key['id'];
}

$filter = ['CATEGORY_ID' => 0, 'ASSIGNED_BY_ID' => $usersID, 'STAGE_ID' => 'WON', '>=CLOSEDATE' => $first_date, '<CLOSEDATE' => $last_date];
$Deals = CCrmDeal::GetListEx([], $filter, false, false, []);

$users_deals = [];
while ($record = $Deals->Fetch()) {
	$users_products = [];
	$products = CCrmDeal::LoadProductRows($record['ID']);
	foreach ($products as $product) {
		$ins_product = CCrmProduct::GetByID($product['PRODUCT_ID']);
		$users_products[] = ['PRODUCT_ID' => $product['PRODUCT_ID'],
			'QUANTITY' => $product['QUANTITY'],
			'CATALOG_ID' => $ins_product['CATALOG_ID'],
			'SECTION_ID' => $ins_product['SECTION_ID']];
	}
	$users_deals[$record['ASSIGNED_BY_ID']][] = ['ID' => $record['ID'],
		'STAGE_ID' => $record['STAGE_ID'],
		'NAME' => "{$record['ASSIGNED_BY_NAME']} {$record['ASSIGNED_BY_LAST_NAME']}",
		'OPPORTUNITY' => $record['OPPORTUNITY'],
		'ASSIGNED_BY_ID' => $record['ASSIGNED_BY_ID'],
		'CLOSEDATE' => $record['CLOSEDATE'],
		'PRODUCTS' => $users_products];
}

echo json_encode($users_deals);



