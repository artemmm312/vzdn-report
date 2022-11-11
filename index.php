<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php"); ?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css"
      integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
<link rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">

<script type=" text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script type=" text/javascript" src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
        crossorigin="anonymous"></script>
<script type=" text/javascript"
        src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>

<div class="container">
	<div class="header d-flex justify-content-between">
		<div class="title fs-3 fw-semibold">
			<p>План продаж по количеству товара</p>
		</div>
		<div class="settings">
			<?php require_once "settings.php" ?>
		</div>
	</div>
	<div class="container">
		<div class="main">
			<div class="progress">
				<div class="progress-bar" role="progressbar" aria-label="Progress by goods" style="width: 25%;"
				     aria-valuenow="100" aria-valuemin="0" aria-valuemax="200">25%
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript" src="js/setting.js"></script>
<script type="text/javascript" src="js/setUsers.js"></script>

<?php
\Bitrix\Main\Loader::includeModule('crm');

function pr($var)
{
	static $int = 0;
	echo '<pre><b style="background: red;padding: 1px 5px;">' . $int . '</b> ';
	print_r($var);
	echo '</pre>';
	$int++;
}

$fd = fopen("settings/lastSettings.json", 'r') or die("не удалось открыть файл");
$settings = null;
while (!feof($fd)) {
	$settings = json_decode(fgets($fd), true);
}
fclose($fd);

pr($settings);
$date = date("d.m.Y H:i:s", mktime(00, 00, 0, 9, 1, 2022));
//var_dump($date);
$general_settings = $settings[0];
$first_date = null;
$last_date = null;
if ($general_settings['season'] === 'Квартал') {
	$month_start = ['0' => 1, '1' => 4, '2' => 7, '3' => 10];
	$month_end = ['0' => 4, '1' => 7, '2' => 10, '3' => 1];
	if($general_settings['month_or_quarter'] === '3') {
		$year = $general_settings['year'] +1;
		$first_date = date("d.m.Y", mktime(0, 0, 0, $month_start[$general_settings['month_or_quarter']], 1, $general_settings['year']));
		$last_date = date("d.m.Y", mktime(0, 0, 0, $month_end[$general_settings['month_or_quarter']], 1, $year));
	} else {
		$first_date = date("d.m.Y", mktime(0, 0, 0, $month_start[$general_settings['month_or_quarter']], 1, $general_settings['year']));
		$last_date = date("d.m.Y", mktime(0, 0, 0, $month_end[$general_settings['month_or_quarter']], 1, $general_settings['year']));
	}
}
var_dump($first_date);
var_dump($last_date);

$users_settings = $settings[1];
$usersID = [];
foreach ($users_settings as $key) {
	$usersID[] = $key['id'];
}

$sections = ['44' => 'tare_product', '45' => 'drink_product'];
pr($usersID);

$filter = ['ASSIGNED_BY_ID' => $usersID, 'STAGE_ID' => 'WON', '>=CLOSEDATE' => $first_date, '<CLOSEDATE' => $last_date];

$Deals = CCrmDeal::GetListEx([],
	['CATEGORY_ID' => 0, 'ASSIGNED_BY_ID' => $usersID, 'STAGE_ID' => 'WON', '>=CLOSEDATE' => $first_date, '<CLOSEDATE' => $last_date],
	false,
	false,
	[]);

$dealData = [];
while ($record = $Deals->Fetch()) {
	$dealData[$record['ID']] = ['ID' => $record['ID'],
		'STAGE_ID' => $record['STAGE_ID'],
		'OPPORTUNITY' => $record['OPPORTUNITY'],
		'ASSIGNED_BY_ID' => $record['ASSIGNED_BY_ID'],
		'CLOSEDATE' => $record['CLOSEDATE']];
}

$products = CCrmDeal::LoadProductRows(336);
$countProduct = 0;
foreach ($products as $key => $value) {
	$countProduct += $value['QUANTITY'];
}

$test = CCrmProduct::GetByID(325);
//$test2 = CCrmProduct::GetList($arOrder = array(), $arFilter = array('ID' => 44), $arSelectFields = array(), $arNavStartParams = false, $arGroupBy = false);

pr($dealData);
pr($products);
pr($countProduct);
pr($test);
//pr($test2);


?>

<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
