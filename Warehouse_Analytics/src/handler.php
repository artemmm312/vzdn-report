<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php"); ?>

<?php

\Bitrix\Main\Loader::includeModule('crm');

$month = (int)$_POST['month_for_store'] + 1;
$first_date = date("01.$month.Y");
$last_date = date('d.m.Y', strtotime($first_date . '+1 month'));


//UF_CRM_625FFF20008DE - Склад
function getStoreData($store_id, $first_date, $last_date, $currency)
{
	$result = ['d_quan' => 0, 'd_sum' => 0, 't_quan' => 0, 't_sum' => 0];
	$filter =
		['CATEGORY_ID' => 0,
			'UF_CRM_625FFF20008DE' => $store_id,
			'STAGE_ID' => 'WON',
			'>=CLOSEDATE' => $first_date,
			'<CLOSEDATE' => $last_date,
			'CURRENCY_ID' => $currency,
			'CHECK_PERMISSIONS' => 'N'
		];
	$Deals = CCrmDeal::GetListEx([], $filter, false, false, ['*', 'UF_*']);
	while ($record = $Deals->Fetch()) {
		$products = CCrmDeal::LoadProductRows($record['ID']);
		foreach ($products as $product) {
			$ins_product = CCrmProduct::GetByID($product['PRODUCT_ID']);
			if ($ins_product['SECTION_ID'] === '45') {
				$result['d_quan'] += $product['QUANTITY'];
				$result['d_sum'] += $record['OPPORTUNITY'];
			}
			if ($ins_product['SECTION_ID'] === '44') {
				$result['t_quan'] += $product['QUANTITY'];
				$result['t_sum'] += $record['OPPORTUNITY'];
			}
		}
	}
	return $result;
}

function getListProducts($section_id)
{
	$product_name = ['id' => '', 'name' => '', 'quan' => 0, 'sum' => 0];
	$result = [];
	$products_data = CCrmProduct::GetList([], ['SECTION_ID' => $section_id, 'CHECK_PERMISSIONS' => 'N'], [], false, false);
	while ($record = $products_data->Fetch()) {
		$product_name['id'] = $record['ID'];
		$product_name['name'] = $record['NAME'];
		$result[] = $product_name;
	}
	return $result;
}


function getProductsForStore($store, $first_date, $last_date, $section_id)
{
	$test = [];
	$productsList = getListProducts($section_id);
	$filter =
		[
			'CATEGORY_ID' => 0,
			'UF_CRM_625FFF20008DE' => $store,
			'STAGE_ID' => 'WON',
			'>=CLOSEDATE' => $first_date,
			'<CLOSEDATE' => $last_date,
			'CHECK_PERMISSIONS' => 'N'
		];
	$Deals = CCrmDeal::GetListEx([], $filter, false, false, ['*', 'UF_*']);
	while ($record = $Deals->Fetch()) {
		$products_row = CCrmDeal::LoadProductRows($record['ID']);
		foreach ($products_row as $product) {
			$ins_product = CCrmProduct::GetByID($product['PRODUCT_ID']);
			if ($ins_product['SECTION_ID'] === $section_id) {
				$found_key = array_search($ins_product['ID'], array_column($productsList, 'id'), true);
				if($product['TAX_RATE'] !== 0) {
					$sum = $product['PRICE_EXCLUSIVE'] * $product['QUANTITY'];
					$tax = $sum / 100 * $product['TAX_RATE'];
					$productsList[$found_key]['sum'] += $sum + $tax;
				} else {
					$productsList[$found_key]['sum'] += $product['PRICE_EXCLUSIVE'] * $product['QUANTITY'];
				}
				$productsList[$found_key]['quan'] += $product['QUANTITY'];
			}
		}
	}
	return $productsList;
}

$storeProductList =
	[
		'store_162-tare' => getProductsForStore('162', $first_date, $last_date, '44'),
		'store_162-drink' => getProductsForStore('162', $first_date, $last_date, '45'),
		'store_164-tare' => getProductsForStore('164', $first_date, $last_date, '44'),
		'store_164-drink' => getProductsForStore('164', $first_date, $last_date, '45'),
		'store_165-tare' => getProductsForStore('165', $first_date, $last_date, '44'),
		'store_165-drink' => getProductsForStore('165', $first_date, $last_date, '45'),
		'store_163-tare' => getProductsForStore('163', $first_date, $last_date, '44'),
		'store_163-drink' => getProductsForStore('163', $first_date, $last_date, '45'),
	];

$warehousesRB = [
	'warehousesRB' =>
		[
			['store' => 'Склад Витебск'] + getStoreData('162', $first_date, $last_date, 'BYN'),
			['store' => 'Склад Минск'] + getStoreData('164', $first_date, $last_date, 'BYN'),
			['store' => 'Склад Полоцк'] + getStoreData('165', $first_date, $last_date, 'BYN'),
		],
];

$warehousesRF = [
	'warehousesRF' =>
		[
			['store' => 'Склад Витебск без акциза'] + getStoreData('163', $first_date, $last_date, 'RUB'),
		],
];

header('Content-Type: application/json');
$result = $warehousesRB + $warehousesRF + $storeProductList;
echo json_encode($result);