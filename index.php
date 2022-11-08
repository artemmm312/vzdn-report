<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php"); ?>
<!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
        crossorigin="anonymous"></script>

<script type=" text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<link rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">

<script type=" text/javascript"
        src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>


<div class="container">
	<div class="header d-flex justify-content-between">
		<div class="title fs-3 fw-semibold">План продаж по количеству товара</div>
		<div class="settings">
			<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
				Настройка
			</button>
			<!-- Modal -->
			<div class="modal modal-lg fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false"
			     tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
					<div class="modal-content">
						<div class="modal-header">
							<h1 class="modal-title fs-5" id="staticBackdropLabel">План продаж по количеству
								товара</h1>
							<button type="button" class="btn-close" data-bs-dismiss="modal"
							        aria-label="Close"></button>
						</div>
						<div class="modal-body">
							<div class="chose-date row mb-3">
								<div class="season col-4">
									<select class="selectpicker" data-width="100%">
										<option>Месяц</option>
										<option>Квартал</option>
										<option>Год</option>
									</select>
								</div>
								<div class="month col-4">
									<select class="selectpicker" data-size="5" data-width="100%">
									</select>
								</div>
								<div class="quarter col-4">
									<select class="selectpicker" data-width="100%">
										<option>1 квартал</option>
										<option>2 квартал</option>
										<option>3 квартал</option>
										<option>4 квартал</option>
									</select>
								</div>
								<div class="year col-4">
									<select class="selectpicker" data-size="5" data-width="100%">
									</select>
								</div>
							</div>
							<div class="chose-form mb-3">
								<select class="selectpicker">
									<option>Общее</option>
									<option>По категориям товара</option>
								</select>
							</div>
							<div class="chose-users">
								<?php require_once "setting.php" ?>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
							<button type="button" class="btn btn-primary">Применить</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript" src="js/date.js"></script>
<?php
\Bitrix\Main\Loader::includeModule('crm');

$Deals = CCrmDeal::GetListEx([],
	['ASSIGNED_BY_ID' => 23, 'BEGINDATE' => '28.10.2022'],
	false,
	false,
	[]);

$dealData = [];
while ($record = $Deals->Fetch()) {
	$dealData['ID'] = $record['ID'];
}

$products = CCrmDeal::LoadProductRows($dealData['ID']);

$countProduct = 0;
foreach ($products as $key => $value) {
	$countProduct += $value['QUANTITY'];
}

$test = CCrmProduct::GetByID(319);

function pr($var)
{
	static $int = 0;
	echo '<pre><b style="background: red;padding: 1px 5px;">' . $int . '</b> ';
	print_r($var);
	echo '</pre>';
	$int++;
}

$test2 = CCrmProduct::GetList($arOrder = array(), $arFilter = array('ID' => 44), $arSelectFields = array(), $arNavStartParams = false, $arGroupBy = false);

pr($dealData);
pr($products);
pr($countProduct);
pr($test);
pr($test2);


?>

<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
