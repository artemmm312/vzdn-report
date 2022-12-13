<?php
\Bitrix\Main\Loader::includeModule('crm');

$usersData = CUser::GetList($by, $order, ['ACTIVE' => 'Y']);
$fio = [];
while ($item = $usersData->Fetch()) {
	$fio[$item['ID']] = "{$item['NAME']} " . $item['LAST_NAME'];
}
?>

<div class="row">
	<div class="col-6 text-center" style="overflow: hidden;">
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
				$exception_users = [1, 3, 4, 5, 8, 9, 18, 20, 22, 23, 24];
				foreach ($fio as $key => $value) {
					if(in_array($key, $exception_users, false) === false) {
						$key = htmlspecialchars ($key);
						echo "<option value='$key'>" . htmlspecialchars ($value) . "</option>";
					}
				}
			?>
		</select>
	</div>
	<div class="col-6 text-center">
		<button class="btn btn-info" id="addUsers" type="button" disabled data-bs-toggle="button">
			Добавить выбранных пользователей
		</button>
	</div>
</div>



