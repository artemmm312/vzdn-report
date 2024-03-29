<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php"); ?>

<?php
\Bitrix\Main\Loader::includeModule('crm');
\Bitrix\Main\Loader::includeModule('main');

$fileContent = file_get_contents(dirname(__DIR__) . "/settings/lastSettings.json");
if (false === $fileContent) {
	die('не удалось открыть файл');
}
$settings = json_decode($fileContent, true);

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

function getDataDeal($filter) {
	$Deals= CCrmDeal::GetListEx([], $filter, false, false, []);
	$data_deals = [];
	while ($record = $Deals->Fetch()) {
		$opportunity_BYN = 0;
		$opportunity_RUB = 0;
		if($record['CURRENCY_ID'] === 'BYN') {
			$opportunity_BYN = $record['OPPORTUNITY'];
		} elseif ($record['CURRENCY_ID'] === 'RUB') {
			$opportunity_RUB = $record['OPPORTUNITY'];
		}
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
				'OPPORTUNITY_BYN' => $opportunity_BYN,
				'OPPORTUNITY_RUB' => $opportunity_RUB,
				'ASSIGNED_BY_ID' => $record['ASSIGNED_BY_ID'],
				'CLOSEDATE' => $record['CLOSEDATE'],
				'PRODUCTS' => $data_products
			];
	}
	return $data_deals;
}

$data_deals = [];

if ($general_settings['type_of_plane'] === 'Общий') {
	$no_user = [1, 3, 4, 5, 8, 9, 18, 20, 24];
	//$filter = ['CATEGORY_ID' => [0, 5], 'STAGE_ID' => 'WON', '>=CLOSEDATE' => $first_date, '<CLOSEDATE' => $last_date, '!SOURCE_ID' => 'CALLBACK', 'CHECK_PERMISSIONS' => 'N'];
	$filter_managers = ['CATEGORY_ID' => 0, '!ASSIGNED_BY_ID' => $no_user, 'STAGE_ID' => 'WON', '!SOURCE_ID' => 'CALLBACK', '>=CLOSEDATE' => $first_date, '<CLOSEDATE' => $last_date, 'CHECK_PERMISSIONS' => 'N'];
	$filter_agents = ['CATEGORY_ID' => 5, '!ASSIGNED_BY_ID' => $no_user, 'STAGE_ID' => 'C5:LOSE', '>=CLOSEDATE' => $first_date, '<CLOSEDATE' => $last_date, 'CHECK_PERMISSIONS' => 'N'];
	$data_deals_managers = getDataDeal($filter_managers);
	$data_deals_agents = getDataDeal($filter_agents);
	$data_deals = $data_deals_managers + $data_deals_agents;
} elseif ($general_settings['type_of_plane'] === 'По пользователям') {
	$users_plane = $settings[1];
	$user_managers = [];
	$user_agents = [];
	$responsible_for_agents = [];
	foreach ($users_plane as $key) {
		$user_group = CUser::GetUserGroup($key['id']);
		if (in_array('18', $user_group, false)){
			$user_agents[] = $key['id'];
		} /*elseif (in_array('21', $user_group, false)) {
			$responsible_for_agents = $key['id'];
		}*/ else {
			$user_managers[] = $key['id'];
		}
	}
	$filter_managers = ['CATEGORY_ID' => 0, 'ASSIGNED_BY_ID' => $user_managers, 'STAGE_ID' => 'WON', '!SOURCE_ID' => 'CALLBACK', '>=CLOSEDATE' => $first_date, '<CLOSEDATE' => $last_date, 'CHECK_PERMISSIONS' => 'N'];
	$filter_agents = ['CATEGORY_ID' => 5, 'ASSIGNED_BY_ID' => $user_agents, 'STAGE_ID' => 'C5:LOSE', '>=CLOSEDATE' => $first_date, '<CLOSEDATE' => $last_date, 'CHECK_PERMISSIONS' => 'N'];
	//$filter_responsible_for_agents = ['CATEGORY_ID' => 0, 'ASSIGNED_BY_ID' => $responsible_for_agents, 'STAGE_ID' => 'WON', '>=CLOSEDATE' => $first_date, '<CLOSEDATE' => $last_date, 'CHECK_PERMISSIONS' => 'N'];
	$data_deals_managers = getDataDeal($filter_managers);
	$data_deals_agents = getDataDeal($filter_agents);
	$data_deals = $data_deals_managers + $data_deals_agents;
}

header('Content-Type: application/json');
echo json_encode($data_deals);
