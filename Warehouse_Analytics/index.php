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

<div class="container">
	<table id="myTable" class="table table-hover table-bordered border border-dark">
		<thead class="align-middle">
		<tr>
			<th class="text-center" rowspan="2">СКЛАДЫ:</th>
			<th class="text-center" colspan="2">Бутылки</th>
			<th class="text-center" colspan="2">Напитки</th>
		</tr>
		<tr class="text-center">
			<th style="background-color: rgb(220,233,245)">Кол-во</th>
			<th style="background-color: rgb(220,233,245)">Сумма</th>
			<th style="background-color: rgb(250,226,213)">Кол-во</th>
			<th style="background-color: rgb(250,226,213)">Сумма</th>
		</tr>
		</thead>
		<tbody class="table-group-divider">
		</tbody>
		<tfoot>
		</tfoot>
	</table>
</div>

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

$first_date = "01.01.2023";
$last_date = "31.03.2023";
//UF_CRM_625FFF20008DE - Склад
function getStorData($store, $first_date, $last_date)
{
	$result = ['drink' => ['quan' => 0, 'sum' => 0], 'tare' => ['quan' => 0, 'sum' => 0]];
	$filter = ['CATEGORY_ID' => 0, 'UF_CRM_625FFF20008DE' => $store, 'STAGE_ID' => 'WON', '>=CLOSEDATE' => $first_date, '<CLOSEDATE' => $last_date, 'CHECK_PERMISSIONS' => 'N'];
	$Deals = CCrmDeal::GetListEx([], $filter, false, false, ['*', 'UF_*']);
	while ($record = $Deals->Fetch()) {
		$products = CCrmDeal::LoadProductRows($record['ID']);
		foreach ($products as $product) {
			$ins_product = CCrmProduct::GetByID($product['PRODUCT_ID']);
			if ($ins_product['SECTION_ID'] === '45') {
				$result['drink']['quan'] += $product['QUANTITY'];
				$result['drink']['sum'] += $record['OPPORTUNITY'];
			}
			if ($ins_product['SECTION_ID'] === '44') {
				$result['tare']['quan'] += $product['QUANTITY'];
				$result['tare']['sum'] += $record['OPPORTUNITY'];
			}
		}
	}
	return $result;
}

$warehouses = [
	'Склад Витебск напитки' => getStorData('162', $first_date, $last_date),
	'Склад Витебск без акциза' => getStorData('163', $first_date, $last_date),
	'Склад Минск' => getStorData('164', $first_date, $last_date),
	'Склад Полоцк' => getStorData('165', $first_date, $last_date),
];


pr($warehouses);

?>

<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
