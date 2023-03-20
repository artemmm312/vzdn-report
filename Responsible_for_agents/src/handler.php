<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php"); ?>

<?php

\Bitrix\Main\Loader::includeModule('crm');

$month = (int)$_POST['month_for_agents'] + 1;
$first_date = date("01.$month.Y");
$last_date = date('d.m.Y', strtotime($first_date . '+1 month'));

$users_id = CGroup::GetGroupUser('21');

function getUsersData($users_id)
{
	$result = [];
	foreach ($users_id as $user_id) {
		$userData = CUser::GetByID($user_id);
		$record = $userData->Fetch();
		$result[] =
			[
				'id' => $record['ID'],
				'name' => $record["NAME"] . ' ' . $record["LAST_NAME"],
				'quan_all' => 0,
				'sum_all' => 0,
				'quan' => 0,
				'sum' => 0,
			];
	}
	return $result;
}


$filter =
	[
		'CATEGORY_ID' => 0,
		'ASSIGNED_BY_ID' => $users_id,
		'STAGE_ID' => 'WON',
		'>=CLOSEDATE' => $first_date,
		'<CLOSEDATE' => $last_date,
		'CHECK_PERMISSIONS' => 'N'
	];

function getData($filter, $users_id)
{
	$result = getUsersData($users_id);
	$Deals = CCrmDeal::GetListEx([], $filter, false, false, ['*', 'UF_*']);
	while ($record = $Deals->Fetch()) {
		$found_key = array_search($record['ASSIGNED_BY_ID'], array_column($result, 'id'), true);
		++$result[$found_key]['quan_all'];
		$result[$found_key]['sum_all'] += $record['OPPORTUNITY'];
		if($record['SOURCE_ID'] !== 'CALLBACK') {
			$found_key = array_search($record['ASSIGNED_BY_ID'], array_column($result, 'id'), true);
			++$result[$found_key]['quan'];
			$result[$found_key]['sum'] += $record['OPPORTUNITY'];
		}
	}
	return $result;
}

header('Content-Type: application/json');
$result = ['data' => getData($filter, $users_id)];
//$result = ['data' => getData($filter,$filter2, $users_id)];
//$result = ['data' => getUsersData($users_id)];
echo json_encode($result);
