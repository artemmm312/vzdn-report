<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php"); ?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css"
      integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
<link rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">
<link rel="stylesheet" type="text/css"
      href="https://cdn.datatables.net/v/bs5/dt-1.12.1/date-1.1.2/sb-1.3.4/sp-2.0.2/datatables.min.css">

<script type=" text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script type=" text/javascript" src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
        crossorigin="anonymous"></script>
<script type=" text/javascript"
        src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>
<script type="text/javascript"
        src="https://cdn.datatables.net/v/bs5/dt-1.12.1/date-1.1.2/sb-1.3.4/sp-2.0.2/datatables.min.js"></script>

<div class="body">
	<div class="container-fluid">

		<div class="container">
			<div class="chose-mounth pb-2">
				<select class="selectpicker m-auto" id="month_agents"
				        title="Месяц"
				        data-size="5"
				        data-width="50%">
				</select>
			</div>
		</div>

		<div class="container">
			<table id="responsible_for_agents" class="table table-hover table-bordered border-dark">
				<thead class="align-middle">
				<tr>
					<th class="text-center">Сотрудник</th>
					<th class="text-center" style="background-color: rgb(231,241,255)">Количество (ОБЩЕЕ)</th>
					<th class="text-center" style="background-color: rgb(229,255,239)">Сумма (ОБЩЕЕ)</th>
					<th class="text-center" style="background-color: rgb(231,241,255)">Количество (СВОЁ)</th>
					<th class="text-center" style="background-color: rgb(229,255,239)">Сумма (СВОЁ)</th>
				</tr>
				</thead>
				<tbody class="table-group-divider">
				</tbody>
				<tfoot>
				<tr class="text-center">
					<td>Итого:</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				</tfoot>
			</table>
		</div>

	</div>
</div>

<script type="text/javascript" src="js/script.js"></script>

<?php

/*\Bitrix\Main\Loader::includeModule('crm');

function pr($var)
{
	static $int = 0;
	echo '<pre><b style="background: red;padding: 1px 5px;">' . $int . '</b> ';
	print_r($var);
	echo '</pre>';
	$int++;
}

$first_date = "01.01.2023";
$last_date = "01.02.2023";

$users = CGroup::GetGroupUser('21');

$filter =
	[
		'CATEGORY_ID' => 0,
		'ASSIGNED_BY_ID' => $users,
		'STAGE_ID' => 'WON',
		'>=CLOSEDATE' => $first_date,
		'<CLOSEDATE' => $last_date,
		'CHECK_PERMISSIONS' => 'N'
	];

function getData($filter, $users)
{
	$result = [];
	foreach ($users as $user) {
		$result[] = ['id' => $user, 'name' => '', 'quan' => 0, 'sum' => 0];
	}
	$Deals = CCrmDeal::GetListEx([], $filter, false, false, ['*', 'UF_*']);
	//$deal_data = [];
	while ($record = $Deals->Fetch()) {
		$found_key = array_search($record['ASSIGNED_BY_ID'], array_column($result, 'id'), true);
		$result[$found_key]['name'] = $record['ASSIGNED_BY_NAME'] . $record['ASSIGNED_BY_LAST_NAME'];
		++$result[$found_key]['quan'];
		$result[$found_key]['sum'] += $record['OPPORTUNITY'];
	}
	//pr($result);
	return $result;
}

header('Content-Type: application/json');
$result = getData($filter, $users);
echo json_encode($result);*/
/*$users_id = CGroup::GetGroupUser('21');

function getUsersData($users_id)
{
	$result = [];
	foreach ($users_id as $user_id) {
		$userData = CUser::GetByID($user_id);
		$record = $userData->Fetch();
		$result[] = ['id1' => $record['ID'], 'name' => $record["NAME"] . ' ' . $record["LAST_NAME"], 'quan' => 0, 'sum' => 0];
		$result[] = ['id2' => $record['ID'], 'name' => $record["NAME"] . ' ' . $record["LAST_NAME"] . ' (СВОИ)', 'quan' => 0, 'sum' => 0];
	}
	return $result;
}
echo '<pre>';
$result = getUsersData($users_id);
$found_key = array_search('20', array_column($result, 'id1'), true);
var_dump($found_key);
var_dump(getUsersData($users_id));*/


?>

<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
