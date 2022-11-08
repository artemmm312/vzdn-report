<?php
\Bitrix\Main\Loader::includeModule('crm');

$usersData = CUser::GetList($by, $order, ['ACTIVE' => 'Y']);
$fio = [];
while ($item = $usersData->Fetch()) {
	$fio[$item['ID']] = "{$item['NAME']} " . $item['LAST_NAME'];
}
//var_dump($fio);

echo '
<link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">

    <script type=" text/javascript"
            src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>
            
<div class="container-fluid h-100 bg-light">
	<div class="row">
		<div class="col-6 text-center align-items-center justify-content-center" style="overflow: hidden;">
			<select id="myS" class="selectpicker"
					data-width="fit"
					data-live-search="true"
					data-container="body"
					data-size="7"
					multiple
					data-actions-box="true"
					data-selected-text-format="count"
					data-none-selected-text="Выбор пользователей"
					data-deselect-all-text="Убрать всех"
					data-select-all-text="Выбрать всех"
					data-none-results-text="Ничего не найдено {0}"
					data-count-selected-text="Выбрано {0} (из {1})">';

foreach ($fio as $key => $value) {
	echo "<option value='$key'>" . $value . "</option>";
}

echo '</select>
		</div>
		<button id="myB" type="button" class="btn btn-info col-6" disabled data-bs-toggle="button">Добавить выбранных
			пользователей
		</button>
	</div>
	<div class="row">
		<ul class="user_list list-group mt-3">';

$fd = fopen("usersList/usersList.json", 'r') or die("не удалось открыть файл");
$usersList = null;
while (!feof($fd)) {
	$usersList = json_decode(fgets($fd), true);
}
fclose($fd);

$count = count($usersList);
for ($i = 0; $i < $count; $i++) {
	$value = $usersList[$i]['id'];
	$text = $usersList[$i]['name'];
	echo "<li class='list-group-item d-flex justify-content-start align-items-center row' id='$value' value='$value'>
	<div class='user col-6 d-flex justify-content-between'>
		<button id='closeB' type='button' class='btn-close' aria-label='Close'></button>
		<p class='mb-0 text-center'>$text</p>
	</div>  
  <div class='general col-3'>
    <label for='general' class='form-label mb-0'>Общее</label>
  	<input type='text' class='form-control' id='general'>
  </div>
  <div class='tare col-3'>
    <label for='tare' class='form-label mb-0'>ПЭТ-тара</label>
  	<input type='text' class='form-control' id='tare'>
  </div>
  <div class='drink col-3'>
    <label for='drink' class='form-label mb-0'>Вода, напитки</label>
  	<input type='text' class='form-control' id='drink'>
  </div>
 </li>";
}

echo '</ul>
	</div>
</div>
<script type="text/javascript" src="js/script.js"></script>';

