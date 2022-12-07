<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php"); ?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css"
      integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
<link rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">
<link rel="stylesheet" type="text/css"
      href="https://cdn.datatables.net/v/bs5/dt-1.12.1/date-1.1.2/sb-1.3.4/sp-2.0.2/datatables.min.css"/>

<script type=" text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script type=" text/javascript" src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
        crossorigin="anonymous"></script>
<script type=" text/javascript"
        src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>
<script type="text/javascript"
        src="https://cdn.datatables.net/v/bs5/dt-1.12.1/date-1.1.2/sb-1.3.4/sp-2.0.2/datatables.min.js"></script
<?php
global $USER;
$userId = $USER->GetID();
?>
<div class="body">
<div class="container-fluid w-100 min-vh-100">
	<div class="container">
		<div class="header d-flex justify-content-between">
			<div class="title fs-3 fw-semibold">
				<p class="shadow-sm">План продаж по количеству товара</p>
			</div>
			<div class="chose-save">
				<select class="selectpicker m-auto" id="saved_plane"
				        title="Выбор сохранённого плана"
				        data-size="5"
				        data-width="100%">
				</select>
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
</div>
</div>
<script type='text/javascript'>
	let userID = <?php echo $userId; ?>
</script>
<script type="text/javascript" src="js/functions.js"></script>
<script type="text/javascript" src="js/events.js"></script>
<script type="text/javascript" src="js/loader.js"></script>

<?php

/*function pr($var)
{
	static $int = 0;
	echo '<pre><b style="background: red;padding: 1px 5px;">' . $int . '</b> ';
	print_r($var);
	echo '</pre>';
	$int++;
}

$dir = 'settings/saved';
$scanned_directory = array_diff(scandir($dir), array('..', '.'));
pr($scanned_directory);

$top_user = '1';
$main_users = ['4', '5', '7'];
$main_of_group = ['14', '15'];
$one_group = ['10', '11', '12', '13', '17', '19'];
$result = [];
foreach ($scanned_directory as $file) {
	$test = json_decode(file_get_contents("settings/saved/" . $file), true);
	switch ($test[0]['type_of_plane']) {
		case 'Общий':
			$result[] = $file;
			break;
		case 'По пользователям':
			if ($userId === $top_user || in_array($userId, $main_users, true)) {
				$result[] = $file;
			}
			if (in_array($userId, $main_of_group, true)) {
				if (in_array($userId, $test[1], true)) {
					$result[] = $file;
				}
				foreach ($one_group as $key) {
					if (in_array($key, $test[1], true)) {
						$result[] = $file;
					}
				}
			}
			if (in_array($userId, $one_group, true) && in_array($userId, $test[1], true)) {
				$result[] = $file;
			}
			break;
	}
}
pr($result);*/

?>

<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
