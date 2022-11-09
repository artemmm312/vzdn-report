<?php
\Bitrix\Main\Loader::includeModule('crm');

$usersData = CUser::GetList($by, $order, ['ACTIVE' => 'Y']);
$fio = [];
while ($item = $usersData->Fetch()) {
	$fio[$item['ID']] = "{$item['NAME']} " . $item['LAST_NAME'];
}
?>

<div class="container-fluid h-100 bg-light">
	<div class="row">
		<div class="col-6 text-center align-items-center justify-content-center" style="overflow: hidden;">
			<select id="Users" class="selectpicker"
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
			        data-count-selected-text="Выбрано {0} (из {1})">

				<?php
				foreach ($fio as $key => $value) {
					echo "<option value='$key'>" . $value . "</option>";
				}
				?>

			</select>
		</div>
		<button id="addUsers" type="button" class="btn btn-info col-6" disabled data-bs-toggle="button">
			Добавить выбранных пользователей
		</button>
	</div>
	<div class="row">
		<ul class="user_list list-group mt-3">

			<?php
			$fd = fopen("settings/lastSettings.json", 'r') or die("не удалось открыть файл");
			$settings = null;
			while (!feof($fd)) {
				$settings = json_decode(fgets($fd), true);
			}
			fclose($fd);

			$test = $settings[0];
			$test2 = $settings[1];



			$count = count(test2);
			var_dump($test2);
			for ($i = 0; $i < $count; $i++) {
				$value = $test2[$i]['id'];
				$text = $test2[$i]['name'];
				$general = $test2[$i]['general'];
				$tare = $test2[$i]['tare'];
				$drink = $test2[$i]['drink'];
				echo "<li class='list-group-item d-flex justify-content-start align-items-center row' id='$value' value='$value'>
					<div class='user col-6 d-flex justify-content-between'>
						<button id='closeB' type='button' class='btn-close' aria-label='Close'></button>
						<p class='mb-0 text-center'>$text</p>
					</div>  
					<div class='general col-3'>
						<label for='general' class='form-label mb-0'>Общее</label>
						<input type='text' class='form-control' id='general' value='$general'>
					</div>
					<div class='tare col-3'>
						<label for='tare' class='form-label mb-0'>ПЭТ-тара</label>
						<input type='text' class='form-control' id='tare' value='$tare'>
					</div>
					<div class='drink col-3'>
						<label for='drink' class='form-label mb-0'>Вода, напитки</label>
						<input type='text' class='form-control' id='drink' value='$drink'>
					</div>
				</li>";
			}
			?>

		</ul>
	</div>
</div>

