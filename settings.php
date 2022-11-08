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
					<?php require_once "selectUsers.php" ?>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
				<button type="button" class="btn btn-primary">Применить</button>
			</div>
		</div>
	</div>
</div>
