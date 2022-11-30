<button class="btn btn-primary shadow" id="settings_btn" type="button" data-bs-toggle="modal" data-bs-target="#settingsModal">
	Настройки <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-tools" viewBox="0 0 16 16">
		<path d="M1 0 0 1l2.2 3.081a1 1 0 0 0 .815.419h.07a1 1 0 0 1 .708.293l2.675 2.675-2.617 2.654A3.003 3.003 0 0 0 0 13a3 3 0 1 0 5.878-.851l2.654-2.617.968.968-.305.914a1 1 0 0 0 .242 1.023l3.356 3.356a1 1 0 0 0 1.414 0l1.586-1.586a1 1 0 0 0 0-1.414l-3.356-3.356a1 1 0 0 0-1.023-.242L10.5 9.5l-.96-.96 2.68-2.643A3.005 3.005 0 0 0 16 3c0-.269-.035-.53-.102-.777l-2.14 2.141L12 4l-.364-1.757L13.777.102a3 3 0 0 0-3.675 3.68L7.462 6.46 4.793 3.793a1 1 0 0 1-.293-.707v-.071a1 1 0 0 0-.419-.814L1 0zm9.646 10.646a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708zM3 11l.471.242.529.026.287.445.445.287.026.529L5 13l-.242.471-.026.529-.445.287-.287.445-.529.026L3 15l-.471-.242L2 14.732l-.287-.445L1.268 14l-.026-.529L1 13l.242-.471.026-.529.445-.287.287-.445.529-.026L3 11z"/>
	</svg>
</button>
<!-- Основное модальное окно с настройками плана -->
<div class="modal modal-lg fade" id="settingsModal" data-bs-backdrop="static" data-bs-keyboard="false"
     tabindex="-1" aria-labelledby="settingsModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
		<div class="modal-content">
			<div class="modal-header d-flex justify-content-between">
				<h1 class="modal-title fs-5" id="staticBackdropLabel">Настройки плана</h1>
				<div class="d-flex">
					<div class="container text-center mx-2" style="width: 370px;">
						<select class="selectpicker m-auto" id="saved_settings"
						        title="Выбор сохранённой настройки"
						        data-size="5"
						        data-width="100%">
						</select>
						<div class="row mt-1">
							<div class="col-4">
								<button class="btn btn-secondary" id="clear_save" type="button"
								        style="--bs-btn-padding-y: 3px; --bs-btn-padding-x: 3px; --bs-btn-font-size: 10px;">Очистить
									выбор
								</button>
							</div>
							<div class="col-4">
								<button class="btn btn-primary" id="load_save" type="button"
								        style="--bs-btn-padding-y: 3px; --bs-btn-padding-x: 3px; --bs-btn-font-size: 9px;">Загрузить
									выбранное
								</button>
							</div>
							<div class="col-4">
								<button class="btn btn-danger" id="delete_save" type="button"
								        style="--bs-btn-padding-y: 3px; --bs-btn-padding-x: 3px; --bs-btn-font-size: 9px;"
								        data-bs-toggle="modal" data-bs-target="#deletion_confirmation">
									Удалить выбранное
								</button>
							</div>
						</div>
					</div>
					<button class="btn-close shadow-sm" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
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
				<div class="row">
					<div class="type_of_plane col-6 mx-auto my-3">
						<select class="selectpicker" id="type_of_plane" data-width="100%">
							<option>Общий</option>
							<option>По пользователям</option>
						</select>
					</div>
				</div>
				<div class="row">
					<div class="quantity_of_product col-6 mx-auto mb-3">
						<label class="form-label mb-0" for="quantity_of_tare" style="font-size: 14px">Планируемое количество реализовать "ПЭТ-тара":</label>
						<input class="form-control" id="quantity_of_tare" type="number" value="0" min="0">
					</div>
					<div class="quantity_of_product col-6 mx-auto mb-3">
						<label class="form-label mb-0" for="quantity_of_drink" style="font-size: 14px">Планируемое количество реализовать "Вода, напитки":</label>
						<input class="form-control" id="quantity_of_drink" type="number" value="0" min="0">
					</div>
				</div>
				<div class="row">
					<div class="type_of_product col-6 mx-auto mb-3">
						<select class="selectpicker" id="type_of_product" data-width="100%">
							<option>Общее</option>
							<option>По категориям товара</option>
						</select>
					</div>
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
				<button class="btn btn-secondary shadow-sm" type="button" data-bs-dismiss="modal">
					Закрыть
				</button>
				<button class="btn btn-primary shadow-sm" id="apply" type="button">
					Применить
				</button>
				<button class="btn btn-success shadow-sm" id="save" type="button" data-bs-target="#settingsSaved" data-bs-toggle="modal">
					Сохранить план
				</button>
			</div>
		</div>
	</div>
</div>
<!-- Модальное окно с сохранением настроек плана -->
<div class="modal fade" id="settingsSaved" aria-hidden="true" aria-labelledby="settingsSavedLabel" tabindex="-1">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h1 class="modal-title fs-5">Сохранение настроек</h1>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div>
					<label class="form-label mb-0" for="saved_name">Введите название для сохраняемых настрек:</label>
					<input class="form-control" id="saved_name" type="text" placeholder="Введите название" pattern="\d [0-9]">
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-secondary shadow-sm" type="button" data-bs-target="#settingsModal"
				        data-bs-toggle="modal">
					Отмена
				</button>
				<button class="btn btn-success shadow-sm" id="push_save" type="button" data-bs-target="#settingsModal"
				        data-bs-toggle="modal">
					<!-- data-bs-dismiss="modal" -->
					Сохранить
				</button>
			</div>
		</div>
	</div>
</div>
<!-- Модальное окно с удалением настроек плана -->
<div class="modal fade" id="deletion_confirmation" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
     aria-labelledby="deletion-confirmation" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h1 class="modal-title fs-5">Удаление сохранённных настроек плана</h1>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div id="deletion_text">
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Отмена</button>
				<button class="btn btn-danger" id="delete_file" type="button" data-bs-dismiss="modal">Удалить</button>
			</div>
		</div>
	</div>
</div>
