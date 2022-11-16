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
			<p class="shadow-sm">План продаж по количеству товара</p>
		</div>
		<div class="settings">
			<?php require_once "settings.php" ?>
		</div>
	</div>
</div>
<div class="container">
	<div class="main">
		<p class="text-date m-2 p-2 text-center shadow-sm"></p>
	</div>
</div>
<script type="text/javascript" src="js/setSetting.js"></script>
<script type="text/javascript" src="js/getSettings.js"></script>

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

$fd = fopen("settings/lastSettings.json", 'r') or die("не удалось открыть файл");
$settings = null;
while (!feof($fd)) {
	$settings = json_decode(fgets($fd), true);
}
fclose($fd);

//pr($settings);

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
var_dump($first_date);
var_dump($last_date);

$users_settings = $settings[1];
$usersID = [];
foreach ($users_settings as $key) {
	$usersID[] = $key['id'];
}
//pr($usersID);

$sections = ['44' => 'tare_product', '45' => 'drink_product'];

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

pr($users_deals);*/
?>

<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
