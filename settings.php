<button type="button" class="btn btn-primary shadow" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
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
					<div class="container-fluid h-100 bg-light">

						<?php require_once "selectUsers.php" ?>

						<div class="row">
							<ul class="users_list list-group mt-3">
							</ul>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
				<button type="button" class="btn btn-primary" id="apply">Применить</button>
				<button type="button" class="btn btn-success" id="save">Сохранить</button>
			</div>
		</div>
	</div>
</div>
