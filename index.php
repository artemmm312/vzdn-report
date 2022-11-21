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
<script type="text/javascript" src="js/saveSettings.js"></script>

<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
