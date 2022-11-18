<button class="btn btn-primary shadow" type="button" data-bs-toggle="modal" data-bs-target="#settingsModal">
	Настройка
</button>
<!-- Modal -->
<div class="modal modal-lg fade" id="settingsModal" data-bs-backdrop="static" data-bs-keyboard="false"
     tabindex="-1" aria-labelledby="settingsModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
		<div class="modal-content">
			<div class="modal-header d-flex justify-content-between">
				<h1 class="modal-title fs-5" id="staticBackdropLabel">Настройки для плана продаж по количеству товара</h1>
				<div class="d-flex">
					<div class="container text-center mx-2" style="width: 370px;">
						<select class="selectpicker m-auto" id="saved-settings"
						        title="Выбор сохранённой настройки"
						        data-size="5"
						        data-width="100%">
						</select>
						<div class="row mt-1">
							<div class="col-4"><button class="btn btn-secondary" id="clear-save" type="button" style="--bs-btn-padding-y: 3px; --bs-btn-padding-x: 3px; --bs-btn-font-size: 10px;">Очистить выбор</button></div>
							<div class="col-4"><button class="btn btn-primary" id="load-save" type="button" style="--bs-btn-padding-y: 3px; --bs-btn-padding-x: 3px; --bs-btn-font-size: 9px;">Загрузить выбранное</button></div>
							<div class="col-4"><button class="btn btn-danger" id="delete-save" type="button" style="--bs-btn-padding-y: 3px; --bs-btn-padding-x: 3px; --bs-btn-font-size: 9px;">Удалить выбранное</button></div>
						</div>
					</div>
					<button class="btn-close shadow-sm" type="button" data-bs-dismiss="modal"
					        aria-label="Close"></button>
				</div>
			</div>
			<div class="modal-body">
				<div class="chose_date row mb-3">
					<div class="season col-4">
						<select class="selectpicker" id="season" data-width="100%">
							<option>Месяц</option>
							<option>Квартал</option>
							<option>Год</option>
						</select>
					</div>
					<div class="month_or_quarter col-4">
						<select class="selectpicker" id="month_or_quarter" data-size="4" data-width="100%">
						</select>
					</div>
					<div class="year col-4">
						<select class="selectpicker" id="year" data-size="4" data-width="100%">
						</select>
					</div>
				</div>
				<div class="type_of_product mb-3">
					<select class="selectpicker" id="type_of_product">
						<option>Общее</option>
						<option>По категориям товара</option>
					</select>
				</div>
				<div class="chose_users">
					<div class="container min-h-100 bg-light p-1">

						<?php require_once "selectUsers.php" ?>

						<div class="container-fluid mt-3">
							<ul class="users_list list-group">
							</ul>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-secondary shadow-sm" type="button" data-bs-dismiss="modal">Закрыть</button>
				<button class="btn btn-primary shadow-sm" id="apply" type="button">Применить</button>
				<button class="btn btn-success shadow-sm" id="save" type="button" data-bs-target="#settingsSaved" data-bs-toggle="modal">Сохранить</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="settingsSaved" aria-hidden="true" aria-labelledby="settingsSavedLabel" tabindex="-1">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h1 class="modal-title fs-5" id="exampleModalToggleLabel2">Сохранение настроек</h1>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div>
					<label class="form-label mb-0" for="save-name">Введите название для сохраняемых настрек:</label>
					<input class="form-control" id="save-name" type="text" placeholder="Введите название" pattern="\d [0-9]">
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-secondary shadow-sm" type="button" data-bs-target="#settingsModal" data-bs-toggle="modal">Отмена</button>
				<button class="btn btn-success shadow-sm" id="push-save" type="button" >Сохранить</button>
			</div>
		</div>
	</div>
</div>
