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
				     aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">25%
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

$fd = fopen("usersList/usersList.json", 'r') or die("не удалось открыть файл");
$usersList = null;
while (!feof($fd)) {
	$usersList = json_decode(fgets($fd), true);
}
fclose($fd);

pr($usersList);

$Deals = CCrmDeal::GetListEx([],
	['ASSIGNED_BY_ID' => 23, 'ID' => 313],
	false,
	false,
	[]);

$dealData = [];
while ($record = $Deals->Fetch()) {
	$dealData[record['ID']] = $record;
}

$products = CCrmDeal::LoadProductRows(313);
$countProduct = 0;
foreach ($products as $key => $value) {
	$countProduct += $value['QUANTITY'];
}

//$test = CCrmProduct::GetByID(319);
//$test2 = CCrmProduct::GetList($arOrder = array(), $arFilter = array('ID' => 44), $arSelectFields = array(), $arNavStartParams = false, $arGroupBy = false);

pr($dealData);
pr($products);
pr($countProduct);
//pr($test);
//pr($test2);


?>

<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
