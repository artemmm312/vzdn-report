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
				<select class="selectpicker m-auto" id="month_for_store"
				        title="Месяц"
				        data-size="5"
				        data-width="50%">
				</select>
			</div>
			<table id="storeTableRB" class="table table-hover table-bordered border-dark">
				<thead class="align-middle">
				<tr>
					<th class="text-center" colspan="5">РБ</th>
				</tr>
				<tr>
					<th class="text-center" rowspan="2">СКЛАДЫ:</th>
					<th class="text-center" colspan="2" style="background-color: rgb(238,231,255)">ПЭТ</th>
					<th class="text-center" colspan="2" style="background-color: rgb(255,249,229)">Напитки</th>
				</tr>
				<tr class="text-center">
					<th style="background-color: rgb(230,239,255)">Кол-во</th>
					<th style="background-color: rgb(240,255,236)">Сумма</th>
					<th style="background-color: rgb(230,239,255)">Кол-во</th>
					<th style="background-color: rgb(240,255,236)">Сумма</th>
				</tr>
				</thead>
				<tbody class="table-group-divider">
				</tbody>
				<tfoot>
				<tr class="text-center">
					<td>Всего:</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				</tfoot>
			</table>
			<table id="storeTableRF" class="table table-hover table-bordered border-dark">
				<thead class="align-middle">
				<tr>
					<th class="text-center" colspan="5">РФ</th>
				</tr>
				<tr>
					<th class="text-center" rowspan="2">СКЛАДЫ:</th>
					<th class="text-center" colspan="2" style="background-color: rgb(238,231,255)">ПЭТ</th>
					<th class="text-center" colspan="2" style="background-color: rgb(255,249,229)">Напитки</th>
				</tr>
				<tr class="text-center">
					<th style="background-color: rgb(230,239,255)">Кол-во</th>
					<th style="background-color: rgb(240,255,236)">Сумма</th>
					<th style="background-color: rgb(230,239,255)">Кол-во</th>
					<th style="background-color: rgb(240,255,236)">Сумма</th>
				</tr>
				</thead>
				<tbody class="table-group-divider">
				</tbody>
				<tfoot>
				</tfoot>
			</table>
		</div>

		<div class="container text-center">
			<div class="row d-flex align-items-center mt-5">
				<div class="col-3 text-center">
					<button class="btn btn-info" id="detalization_report" type="button" data-bs-toggle="collapse"
					        data-bs-target="#collapseStore_162" aria-expanded="false" aria-controls="collapseStore_162">
						Склад Витебск
					</button>
				</div>
				<div id="collapseStore_162" class="collapse my-3" aria-labelledby="headingOne">
					<div class="card card-body text-center">
						<h1>Склад Витебск</h1>
						<div class="container-fluid my-2">
							<table id="storeTable_162-tare" class="table-hover table-bordered border rounded-1 w-100">
								<thead>
								<tr>
									<th class="text-center" colspan="3" style="background-color: rgb(238,231,255)">ПЭТ</th>
								</tr>
								<tr class="table-info">
									<th class="text-center">Наименование товара:</th>
									<th class="text-center">Количество</th>
									<th class="text-center">Сумма</th>
								</tr>
								</thead>
							</table>
						</div>
						<div class="container-fluid my-2">
							<table id="storeTable_162-drink" class="table-hover table-bordered border rounded-1 w-100">
								<thead>
								<tr>
									<th class="text-center" colspan="3" style="background-color: rgb(255,249,229)">Напитки</th>
								</tr>
								<tr class="table-info">
									<th class="text-center">Наименование товара:</th>
									<th class="text-center">Количество</th>
									<th class="text-center">Сумма</th>
								</tr>
								</thead>
							</table>
						</div>
					</div>
				</div>

				<div class="col-3 text-center">
					<button class="btn btn-info" id="detalization_report" type="button" data-bs-toggle="collapse"
					        data-bs-target="#collapseStore_164" aria-expanded="false" aria-controls="collapseStore_164">
						Склад Минск
					</button>
				</div>
				<div id="collapseStore_164" class="collapse my-3" aria-labelledby="headingOne">
					<div class="card card-body text-center">
						<h1>Склад Минск</h1>
						<div class="container-fluid my-2">
							<table id="storeTable_164-tare" class="table-hover table-bordered border rounded-1 w-100">
								<thead>
								<tr>
									<th class="text-center" colspan="3" style="background-color: rgb(238,231,255)">ПЭТ</th>
								</tr>
								<tr class="table-info">
									<th class="text-center">Наименование товара:</th>
									<th class="text-center">Количество</th>
									<th class="text-center">Сумма</th>
								</tr>
								</thead>
							</table>
						</div>
						<div class="container-fluid my-2">
							<table id="storeTable_164-drink" class="table-hover table-bordered border rounded-1 w-100">
								<thead>
								<tr>
									<th class="text-center" colspan="3" style="background-color: rgb(255,249,229)">Напитки</th>
								</tr>
								<tr class="table-info">
									<th class="text-center">Наименование товара:</th>
									<th class="text-center">Количество</th>
									<th class="text-center">Сумма</th>
								</tr>
								</thead>
							</table>
						</div>
					</div>
				</div>

				<div class="col-3 text-center">
					<button class="btn btn-info" id="detalization_report" type="button" data-bs-toggle="collapse"
					        data-bs-target="#collapseStore_165" aria-expanded="false" aria-controls="collapseStore_165">
						Склад Полоцк
					</button>
				</div>
				<div id="collapseStore_165" class="collapse my-3" aria-labelledby="headingOne">
					<div class="card card-body text-center">
						<h1>Склад Полоцк</h1>
						<div class="container-fluid my-2">
							<table id="storeTable_165-tare" class="table-hover table-bordered border rounded-1 w-100">
								<thead>
								<tr>
									<th class="text-center" colspan="3" style="background-color: rgb(238,231,255)">ПЭТ</th>
								</tr>
								<tr class="table-info">
									<th class="text-center">Наименование товара:</th>
									<th class="text-center">Количество</th>
									<th class="text-center">Сумма</th>
								</tr>
								</thead>
							</table>
						</div>
						<div class="container-fluid my-2">
							<table id="storeTable_165-drink" class="table-hover table-bordered border rounded-1 w-100">
								<thead>
								<tr>
									<th class="text-center" colspan="3" style="background-color: rgb(255,249,229)">Напитки</th>
								</tr>
								<tr class="table-info">
									<th class="text-center">Наименование товара:</th>
									<th class="text-center">Количество</th>
									<th class="text-center">Сумма</th>
								</tr>
								</thead>
							</table>
						</div>
					</div>
				</div>

				<div class="col-3 text-center">
					<button class="btn btn-info" id="detalization_report" type="button" data-bs-toggle="collapse"
					        data-bs-target="#collapseStore_163" aria-expanded="false" aria-controls="collapseStore_163">
						Склад Витебск без акциза
					</button>
				</div>
				<div id="collapseStore_163" class="collapse my-3" aria-labelledby="headingOne">
					<div class="card card-body text-center">
						<h1>Склад Витебск без акциза</h1>
						<div class="container-fluid my-2">
							<table id="storeTable_163-tare" class="table-hover table-bordered border rounded-1 w-100">
								<thead>
								<tr>
									<th class="text-center" colspan="3" style="background-color: rgb(238,231,255)">ПЭТ</th>
								</tr>
								<tr class="table-info">
									<th class="text-center">Наименование товара:</th>
									<th class="text-center">Количество</th>
									<th class="text-center">Сумма</th>
								</tr>
								</thead>
							</table>
						</div>
						<div class="container-fluid my-2">
							<table id="storeTable_163-drink" class="table-hover table-bordered border rounded-1 w-100">
								<thead>
								<tr>
									<th class="text-center" colspan="3" style="background-color: rgb(255,249,229)">Напитки</th>
								</tr>
								<tr class="table-info">
									<th class="text-center">Наименование товара:</th>
									<th class="text-center">Количество</th>
									<th class="text-center">Сумма</th>
								</tr>
								</thead>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>

<script type="text/javascript" src="js/script.js"></script>

<?php

/*\Bitrix\Main\Loader::includeModule('crm');
\Bitrix\Main\Loader::includeModule('iblock');

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


$filter =
	['CATEGORY_ID' => 0,
		'ID' => 1960,
		'STAGE_ID' => 'WON',
		'CURRENCY_ID' => 'BYN',
		'CHECK_PERMISSIONS' => 'N'
	];
$Deals = CCrmDeal::GetListEx([], $filter, false, false, ['*', 'UF_*']);
$deal_data = [];
$productsrow_data = [];
$products_data = [];
while ($record = $Deals->Fetch()) {
	$deal_data[] = $record;
	$products = CCrmDeal::LoadProductRows($record['ID']);
	$productsrow_data[] = $products;
	foreach ($products as $product) {
		$ins_product = CCrmProduct::GetByID($product['PRODUCT_ID']);
		$products_data[] = $ins_product;
	}
}


pr($deal_data);
pr($productsrow_data);
pr($products_data);*/
?>

<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
