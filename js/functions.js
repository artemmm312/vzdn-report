//текущая дата
let now = new Date();
//текущий год
let now_year = now.getFullYear();

//массив месяцев
const months = ["Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь"];
//массив кварталов
const quarter = ["1 квартал", "2 квартал", "3 квартал", "4 квартал"];
//массив диапазона годов +-5 от текущего в селекте
const range_for_years = [-5, -4, -3, -2, -1, 0, 1, 2, 3, 4, 5];
//селект месяц/квартал/год
let $season = $('#season');
//селект месяцев/кварталов
let $month_or_quarter = $('#month_or_quarter');
//селект годов
let $year = $('#year');
//селект типа плана
let $type_of_plane = $('#type_of_plane');
//селект типа продуктов(для плана "По пользователям")
let $type_of_product = $('#type_of_product');

//вывод годов в селект
for (let i of range_for_years) {
	$year.append(`<option value="${now_year + i}">${now_year + i}</option>`);
}

//выбор месяц/квартал/год
function choseSeason(season) {
	let $div_month_or_quarter = $('.month_or_quarter');
	switch (season) {
		case 'Месяц':
			$div_month_or_quarter.css('display', 'block');
			$month_or_quarter.find('option').remove();
			for (let i in months) {
				$month_or_quarter.append(`<option value="${i}">${months[i]}</option>`);
			}
			$month_or_quarter.selectpicker('destroy');
			$month_or_quarter.selectpicker('render');
			break;
		case 'Квартал':
			$div_month_or_quarter.css('display', 'block');
			$month_or_quarter.find('option').remove();
			for (let i in quarter) {
				$month_or_quarter.append(`<option value="${i}">${quarter[i]}</option>`);
			}
			$month_or_quarter.selectpicker('destroy');
			$month_or_quarter.selectpicker('render');
			break;
		case 'Год':
			$div_month_or_quarter.css('display', 'none');
			break;
	}
}

//выбор плана общий/по пользователям
function choseTypePlane(type_of_plane) {
	let $div_quantity_of_product = $('.quantity_of_product');
	let $div_type_of_product = $('.type_of_product');
	let $div_chose_users = $('.chose_users');
	switch (type_of_plane) {
		case 'Общий':
			$div_quantity_of_product.css('display', 'block');
			$div_type_of_product.css('display', 'none');
			$div_chose_users.css('display', 'none');
			break;
		case 'По пользователям':
			$div_quantity_of_product.css('display', 'none');
			$div_type_of_product.css('display', 'block');
			$div_chose_users.css('display', 'block');
	}
}

//выбор типа продукта общее/по категориям
function choseTypeProduct(type_of_product) {
	let $div_overall_product = $('.overall_product');
	let $div_tare_product = $('.tare_product');
	let $div_drink_product = $('.drink_product');
	switch (type_of_product) {
		case 'Общее':
			$div_overall_product.css('display', 'block');
			$div_tare_product.css('display', 'none');
			$div_drink_product.css('display', 'none');
			break;
		case 'По категориям товара':
			$div_overall_product.css('display', 'none');
			$div_tare_product.css('display', 'block');
			$div_drink_product.css('display', 'block');
			break;
	}
}

//массив id пользователей
let usersID = [];
//массив имен пользователей
let names = [];
//массив пользователей которые уже есть в списке
let users = [];
//селект выбора пользователей
let $Users = $('#Users');

// запись в массив пользователей из списка
function pushUsers() {
	users.length = 0;
	for (let key of $('.users_list li')) {
		users.push({'id': $(key).val(), 'name': $(key).find('#userName').text()});
	}
}

//отключение пунктов в селекте которые есть в списке
function disOption() {
	$Users.find('option').prop('disabled', false);
	for (let user of users) {
		$Users.find(`[value=${user['id']}]`).prop('disabled', true);
	}
	$Users.selectpicker('destroy');
	$Users.selectpicker('render');
}

//сохранение настроек
function saveSettings(file_name = '') {
	let settings;
	let general_settings = {
		'season': $season.val(),
		'month_or_quarter': $month_or_quarter.val(),
		'year': $year.val(),
		'type_of_plane': $type_of_plane.val(),
		//'type_of_product': $type_of_product.val(),
	};
	if ($type_of_plane.val() === 'Общий') {
		let overall_plane = {
			'quantity_of_tare': $('#quantity_of_tare').val(),
			'quantity_of_drink': $('#quantity_of_drink').val(),
		};
		settings = [general_settings, overall_plane];
	} else if ($type_of_plane.val() === 'По пользователям') {
		general_settings.type_of_product = $type_of_product.val();
		let users_plane = [];
		for (let key of $('.users_list li')) {
			let user_setting = {
				'id': $(key).val(),
				'name': $(key).find('#userName').text(),
				'overall_product': $(key).find('#overall_product').val(),
				'tare_product': $(key).find('#tare_product').val(),
				'drink_product': $(key).find('#drink_product').val(),
			}
			users_plane.push(user_setting);
		}
		settings = [general_settings, users_plane];
	}

	$.ajax({
		type: 'POST',
		url: 'src/recordSettings.php',
		data: {'settings': JSON.stringify(settings), 'file_name': file_name},
		success: function (response) {
		},
	})
}

//общие настройки
let general_settings;
//плановые настройки
let overall_plane;
let users_plane;

//получение данных о настройках от сервера
function getSettings(file_name = '') {
	$.ajax({
		type: 'POST', url: 'src/readSettings.php', data: {'file_name': file_name}, success: function (response) {
			let data = jQuery.parseJSON(response);
			general_settings = data[0];
			$season.selectpicker('val', general_settings.season);
			choseSeason($season.val());
			$month_or_quarter.selectpicker('val', general_settings.month_or_quarter);
			$year.selectpicker('val', general_settings.year);
			$type_of_plane.selectpicker('val', general_settings.type_of_plane);
			choseTypePlane($type_of_plane.val());
			if ($type_of_plane.val() === 'Общий') {
				overall_plane = data[1];
				$('#quantity_of_tare').val(overall_plane.quantity_of_tare);
				$('#quantity_of_drink').val(overall_plane.quantity_of_drink);
			} else if ($type_of_plane.val() === 'По пользователям') {
				users_plane = data[1];
				$type_of_product.selectpicker('val', general_settings.type_of_product);
				for (let i = 0; i < users_plane.length; i++) {
					$('.users_list').append(`
						<li class="list-group-item d-flex justify-content-start align-items-center row" id="${users_plane[i].id}" value="${users_plane[i].id}">
							<div class="user col-6 d-flex justify-content-between">
								<button id="deleteUser" type="button" class="btn-close" aria-label="remove user from the list"></button>
								<p class="mb-0 text-center" id="userName">${users_plane[i].name}</p>
							</div>  
						  <div class="overall_product col-3">
						    <label for="overall_product" class="form-label mb-0">Общее</label>
						    <input type="number" class="form-control" id="overall_product" value="${users_plane[i].overall_product}" min="0">
						  </div>
						  <div class="tare_product col-3">
						    <label for="tare_product" class="form-label mb-0">ПЭТ-тара</label>
						    <input type="number" class="form-control" id="tare_product" value="${users_plane[i].tare_product}" min="0">
						  </div>
						  <div class="drink_product col-3">
						    <label for="drink_product" class="form-label mb-0">Вода, напитки</label>
						    <input type="number" class="form-control" id="drink_product" value="${users_plane[i].drink_product}" min="0">
						  </div>
						</li>
					`);
				}
				choseTypeProduct($type_of_product.val());
			}
		},
	})
}

//получение данных от сервера и формирование отчета
async function reportGeneration() {
	await $.ajax({
		type: 'POST', url: 'src/handler.php', success: function (response) {
			let data = jQuery.parseJSON(response);
			let text_of_date = $season.val() === 'Год' ?
				`Показатели по плану продаж за ${$year.val()} год :` :
				`Показатели по плану продаж за ${$month_or_quarter.find('option:selected').text()} ${$year.val()} года :`;
			$('.text-date').append(text_of_date);
			let $main = $('.main');
			console.log('pizdec');
			if ($type_of_plane.val() === 'Общий') {
				let plane_quantity_of_tare = overall_plane.quantity_of_tare;
				let plane_quantity_of_drink = overall_plane.quantity_of_drink;
				let plane_quantity_overall = Number(plane_quantity_of_tare) + Number(plane_quantity_of_drink);
				let quantity_of_tare = 0;
				let quantity_of_drink = 0;
				let opportunity = 0;
				let data_for_usersTable = [];
				for (let key in data) {
					let userData = {'name': '', 'tare': 0, 'drink': 0, 'opportunity': 0};
					for (let deal of data[key]) {
						opportunity += Number(deal.OPPORTUNITY);
						userData.name = deal.NAME;
						userData.opportunity += Number(deal.OPPORTUNITY);
						let products = deal.PRODUCTS;
						for (let product of products) {
							if (product.SECTION_ID === "44") {
								quantity_of_tare += product.QUANTITY;
								userData.tare += product.QUANTITY;
							}
							if (product.SECTION_ID === "45") {
								quantity_of_drink += product.QUANTITY;
								userData.drink += product.QUANTITY;
							}
						}
					}
					data_for_usersTable.push(userData);
				}
				console.log(data_for_usersTable);
				let quantity_of_overall = quantity_of_tare + quantity_of_drink;
				let pct_quantity_of_overall = ((100 * quantity_of_overall) / plane_quantity_overall).toFixed(2);
				let pct_quantity_of_tare = ((100 * quantity_of_tare) / plane_quantity_of_tare).toFixed(2);
				let pct_quantity_of_drink = ((100 * quantity_of_drink) / plane_quantity_of_drink).toFixed(2);
				$main.append(
					`<div class="row d-flex align-items-center mt-3">
						<div class="col-1 text-center">
					    <button class="btn btn-success" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne"
					      style="--bs-btn-padding-y: 3px; --bs-btn-padding-x: 3px; --bs-btn-font-size: 10px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                  <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                  <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
								</svg>
              </button>
            </div>
            <div class="col-11 text-center">
              <label for="progress_overall">План "Общий" (${plane_quantity_overall})</label>
              <div class="progress shadow">
								<div class="progress-bar ${pct_quantity_of_overall > 100 ? 'progress-bar-striped progress-bar-animated' : ''}" id="progress_overall"
								 role="progressbar" aria-label="tare_product" style="width: ${pct_quantity_of_overall}%;" aria-valuenow="${pct_quantity_of_overall}" aria-valuemin="0" aria-valuemax="100">
									${pct_quantity_of_overall}%
								</div>
							</div>
						</div>
					</div>
			    <div id="collapseOne" class="collapse my-3" aria-labelledby="headingOne">
			      <div class="card card-body text-center">
			        <label for="progress_tare">План "Пэт-тара" (${plane_quantity_of_tare})</label>
							<div class="progress mb-2 shadow">
								<div class="progress-bar ${pct_quantity_of_tare > 100 ? 'progress-bar-striped progress-bar-animated' : ''}" id="progress_tare"
								 role="progressbar" aria-label="tare_product" style="width: ${pct_quantity_of_tare}%;" aria-valuenow="${pct_quantity_of_tare}" aria-valuemin="0" aria-valuemax="100">
									${pct_quantity_of_tare}%
								</div>
							</div>
							<label for="progress_drink">План "Вода, напитки" (${plane_quantity_of_drink})</label>
							<div class="progress mb-3 shadow">
								<div class="progress-bar ${pct_quantity_of_drink > 100 ? 'progress-bar-striped progress-bar-animated' : ''}" id="progress_drink"
								 role="progressbar" aria-label="drink_product" style="width: ${pct_quantity_of_drink}%;" aria-valuenow="${pct_quantity_of_drink}" aria-valuemin="0" aria-valuemax="100">
									${pct_quantity_of_drink}%
								</div>
							</div>
							<div class="row g-2">
								<div class="col-3">
									<div class="border border-info bg-info bg-opacity-25 d-flex justify-content-center align-items-center h-100">
										<p class="p-2 m-0">Выполненно по "Общему" плану:<br> ${quantity_of_overall} / ${plane_quantity_overall} единиц.</p>
									</div>
								</div>
								<div class="col-3">
									<div class="border border-warning bg-warning bg-opacity-25 d-flex justify-content-center align-items-center h-100">
										<p class="p-2 m-0">Выполненно по плану "Пэт-тара":<br> ${quantity_of_tare} / ${plane_quantity_of_tare} единиц.</p>
									</div>
								</div>
								<div class="col-3">
									<div class="border border-warning bg-warning bg-opacity-25 d-flex justify-content-center align-items-center h-100">
										<p class="p-2 m-0">Выполненно по плану "Вода, напитки":<br> ${quantity_of_drink} / ${plane_quantity_of_drink} единиц.</p>
									</div>
								</div>
								<div class="col-3">
									<div class="border border-success bg-success bg-opacity-25 d-flex justify-content-center align-items-center h-100">
										<p class="p-2 m-0">На общую сумму:<br> ${opportunity} руб.</p>
									</div>
								</div>
							</div>
							<div class="container-fluid my-2">
								<table id="userTable" class="table-hover table-bordered border rounded-1 w-100">
									<thead>
										<tr class="table-info">
											<th class="text-center">Сотрудник</th>
											<th class="text-center">Пэт-тара</th>
											<th class="text-center">Вода, напитки</th>
											<th class="text-center">Сумма</th>
										</tr>
									</thead>
								</table>
							</div>
			      </div>
			    </div>`
				);
				$('#userTable').DataTable({
					language: {url: 'https://cdn.datatables.net/plug-ins/1.10.19/i18n/Russian.json'},
					data: data_for_usersTable,
					columns: [
						{data: 'name'},
						{data: 'tare'},
						{data: 'drink'},
						{data: 'opportunity'},
					],
				});
			} else if ($type_of_plane.val() === 'По пользователям') {
				for (let user_setting of users_plane) {
					let name = user_setting.name;
					let id = user_setting.id;
					let plane_of_overall_product = user_setting.overall_product;
					let plane_of_tare_product = user_setting.tare_product;
					let plane_of_drink_product = user_setting.drink_product;
					let opportunity = 0;
					let overall_product = 0;
					let tare_product = 0;
					let drink_product = 0;
					if (user_setting.id in data) {
						for (let i = 0; i < data[id].length; i++) {
							opportunity += +data[id][i].OPPORTUNITY;
							let products = data[id][i].PRODUCTS;
							for (let product of products) {
								overall_product += product.QUANTITY;
								if (product.SECTION_ID === "44") {
									tare_product += product.QUANTITY;
								}
								if (product.SECTION_ID === "45") {
									drink_product += product.QUANTITY;
								}
							}
						}
					}
					let pct_overall_product = ((100 * overall_product) / plane_of_overall_product).toFixed(2);
					let pct_drink_product = ((100 * drink_product) / plane_of_drink_product).toFixed(2);
					let pct_tare_product = ((100 * tare_product) / plane_of_tare_product).toFixed(2);
					switch ($type_of_product.val()) {
						case 'Общее':
							$main.append(
								`<div class="user_plane_data" data-id="${user_setting.id}">
									<div class="d-flex flex-column mb-3"> 
										<h4 class="name">${name}</h4>
										<label></label>
										<div class="progress mb-3 shadow">
											<div class="progress-bar ${pct_overall_product >= 100 ? 'progress-bar-striped progress-bar-animated' : ''}"
											 role="progressbar" aria-label="tare_product" style="width: ${pct_overall_product}%;" aria-valuenow="${pct_overall_product}" aria-valuemin="0" aria-valuemax="100">
												${pct_overall_product}%
											</div>
										</div>
										<div class="row g-2">
											<div class="col-3">
												<div class="border border-info bg-info bg-opacity-25 d-flex justify-content-center align-items-center h-100">
													<p class="p-2 m-0">Выполненно по "Общему" плану:<br> ${overall_product} / ${plane_of_overall_product} единиц.</p>
												</div>
											</div>
											<div class="col-3">
												<div class="border border-warning bg-warning bg-opacity-25 d-flex justify-content-center align-items-center h-100">
													<p class="p-2 m-0">Из "Общего" плана "Пэт-тара" составляет:<br> ${tare_product} единиц.</p>
												</div>
											</div>
											<div class="col-3">
												<div class="border border-warning bg-warning bg-opacity-25 d-flex justify-content-center align-items-center h-100">
													<p class="p-2 m-0">Из "Общего" плана "Вода, напитки" составляет:<br> ${drink_product} единиц.</p>
												</div>
											</div>
											<div class="col-3">
												<div class="border border-success bg-success bg-opacity-25 d-flex justify-content-center align-items-center h-100">
													<p class="p-2 m-0">На общую сумму:<br> ${opportunity} руб.</p>
												</div>
											</div>
										</div>
									</div>
								</div>`
							);
							break;
						case 'По категориям товара':
							$main.append(`
								<div class="user_plane_data" data-id="${user_setting.id}">
									<div class="d-flex flex-column mb-3">
										<h4 class="name">${name}</h4>
										<label>Пэт-тара</label>
										<div class="progress mb-2 shadow">
											<div class="progress-bar ${pct_tare_product >= 100 ? 'progress-bar-striped progress-bar-animated' : ''}"
											 role="progressbar" aria-label="tare_product" style="width: ${pct_tare_product}%;" aria-valuenow="${pct_tare_product}" aria-valuemin="0" aria-valuemax="100">
												${pct_tare_product}%
											</div>
										</div>
										<label>Вода, напитки</label>
										<div class="progress mb-3 shadow">
											<div class="progress-bar ${pct_drink_product >= 100 ? 'progress-bar-striped progress-bar-animated' : ''}"
											 role="progressbar" aria-label="drink_product" style="width: ${pct_drink_product}%;" aria-valuenow="${pct_drink_product}" aria-valuemin="0" aria-valuemax="100">
												${pct_drink_product}%
											</div>
										</div>
										<div class="row g-2">
											<div class="col-3">
												<div class="border border-info bg-info bg-opacity-25 d-flex justify-content-center align-items-center h-100">
													<p class="p-2 m-0">Выполненно по плану "Пэт-тара":<br> ${tare_product} / ${plane_of_tare_product} единиц.</p>
												</div>
											</div>
											<div class="col-3">
												<div class="border border-info bg-info bg-opacity-25 d-flex justify-content-center align-items-center h-100">
													<p class="p-2 m-0">Выполненно по плану "Вода, напитки":<br> ${drink_product} / ${plane_of_drink_product} единиц.</p>
												</div>
											</div>
											<div class="col-3">
												<div class="border border-warning bg-warning bg-opacity-25 d-flex justify-content-center align-items-center h-100">
													<p class="p-2 m-0">Общее количество реализованного товара:<br> ${overall_product} единиц.</p>
												</div>
											</div>
											<div class="col-3">
												<div class="border border-success bg-success bg-opacity-25 d-flex justify-content-center align-items-center h-100">
													<p class="p-2 m-0">На общую сумму:<br> ${opportunity} руб.</p>
												</div>
											</div>
										</div>
									</div>
								</div>
							`);
							break;
					}
				}
			}
		}
	})
}

//отображение данных в зависимости от прав
async function checkRights(userID) {
	let top_user = 1;
	let main_users = [4, 5, 7];
	let main_of_group = [14, 15];
	let one_group = [10, 11, 12, 13, 17, 19];
	$('.user_plane_data').css('display', 'none');
	if (main_users.includes(userID) || top_user === userID) {
		$('.user_plane_data').css('display', 'block');
	}
	if (main_of_group.includes(userID)) {
		console.log($(`.user_plane_data[data-id = ${userID}]`));
		$(`.user_plane_data[data-id = ${userID}]`).css('display', 'block');
		for (let id of one_group) {
			$(`.user_plane_data[data-id = ${id}]`).css('display', 'block')
		}
	}
	if (one_group.includes(userID)) {
		$(`.user_plane_data[data-id = ${userID}]`).css('display', 'block');
	}
}

//прогрузка данных, а затем проверка прав на просмотр данных
	async function loader() {
		await reportGeneration();
		await checkRights(userID);
	}

	//сокрытие кнопки настройки от всех кроме топ-юзера
	function checkTopUser(userID) {
		let top_user = 1;
		if(userID === top_user) {
			$('#settings_btn').css('display', 'block');
		} else {
			$('#settings_btn').css('display', 'none');
		}
	}

//селект выбора сохранённой настройки
let $saved_settings = $('#saved_settings');

//получение списка сохраненных настроек
function getListSettings() {
	$saved_settings.find('option').remove();
	$.ajax({
		type: 'POST', url: 'src/getListSettings.php', success: function (response) {
			let data = jQuery.parseJSON(response);
			for (let key in data) {
				let reg = /\.json/;
				if (data[key].match(reg)) {
					data[key] = data[key].replace(reg, '');
				}
				$saved_settings.append(`<option>${data[key]}</option>`);
			}
			$saved_settings.selectpicker('destroy');
			$saved_settings.selectpicker('render');
		}
	})
}