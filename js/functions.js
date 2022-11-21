
let now = new Date(); //текущая дата
let now_year = now.getFullYear(); //текущий год

//массив месяцев
const months = ["Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь"];
//массив кварталов
const quarter = ["1 квартал", "2 квартал", "3 квартал", "4 квартал"];
//массив диапозона годов +-5 от текущего в селекте
const range_for_years = [-5, -4, -3, -2, -1, 0, 1, 2, 3, 4, 5];

let $season = $('#season');
let $month_or_quarter = $('#month_or_quarter');
let $year = $('#year');
let $type_of_product = $('#type_of_product');

//вывод годов в селект
for (let i of range_for_years) {
	$year.append(`<option value="${now_year + i}">${now_year + i}</option>`);
}

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

function choseTypeProduct(type) {
	let $div_overall_product = $('.overall_product');
	let $div_tare_product = $('.tare_product');
	let $div_drink_product = $('.drink_product');
	switch (type) {
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

let usersID = [];
let names = [];
let users = [];
let $Users = $('#Users');

// запись в массив порльзовыателей из списка
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

//сохнанение настроек
function saveSettings(file_name = '') {
	let general_settings = {
		'season': $season.val(),
		'month_or_quarter': $month_or_quarter.val(),
		'year': $year.val(),
		'type_of_product': $type_of_product.val(),
	};
	let users_settings = [];
	for (let key of $('.users_list li')) {
		let user_setting = {
			'id': $(key).val(),
			'name': $(key).find('#userName').text(),
			'overall_product': $(key).find('#overall_product').val(),
			'tare_product': $(key).find('#tare_product').val(),
			'drink_product': $(key).find('#drink_product').val(),
		}
		users_settings.push(user_setting);
	}
	let settings = [general_settings, users_settings];
	$.ajax({
		type: 'POST',
		url: 'src/recordSettings.php',
		data: {'settings': JSON.stringify(settings), 'file_name': file_name},
		success: function (response) {},
	})
}

let general_settings;
let users_settings;

//получение данных о настройках от сервера
function getSettings(file_name = '') {
	$.ajax({
		type: 'POST', url: 'src/readSettings.php', data: {'file_name': file_name}, success: function (response) {
			let data = jQuery.parseJSON(response);
			general_settings = data[0];
			users_settings = data[1];
			$season.selectpicker('val', general_settings.season);
			choseSeason($season.val());
			$month_or_quarter.selectpicker('val', general_settings.month_or_quarter);
			$year.selectpicker('val', general_settings.year);
			$type_of_product.selectpicker('val', general_settings.type_of_product);
			for (let i = 0; i < users_settings.length; i++) {
				$('.users_list').append(`<li class="list-group-item d-flex justify-content-start align-items-center row" id="${users_settings[i].id}" value="${users_settings[i].id}">
				<div class="user col-6 d-flex justify-content-between">
					<button id="deleteUser" type="button" class="btn-close" aria-label="remove user from the list"></button>
					<p class="mb-0 text-center" id="userName">${users_settings[i].name}</p>
				</div>  
			  <div class="overall_product col-3">
			    <label for="overall_product" class="form-label mb-0">Общее</label>
			    <input type="number" class="form-control" id="overall_product" value="${users_settings[i].overall_product}" min="0">
			  </div>
			  <div class="tare_product col-3">
			    <label for="tare_product" class="form-label mb-0">ПЭТ-тара</label>
			    <input type="number" class="form-control" id="tare_product" value="${users_settings[i].tare_product}" min="0">
			  </div>
			  <div class="drink_product col-3">
			    <label for="drink_product" class="form-label mb-0">Вода, напитки</label>
			    <input type="number" class="form-control" id="drink_product" value="${users_settings[i].drink_product}" min="0">
			  </div>
			</li>`);
			}
			choseTypeProduct($type_of_product.val());
		},
	})
}

//получение даных от сервера и формирование отчета
function reportGeneration() {
	$.ajax({
		type: 'POST', url: 'src/handler.php', success: function (response) {
			let data = jQuery.parseJSON(response);
			let text_of_date = $season.val() === 'Год' ?
				`Показатели по плану продаж за ${$year.val()} год :` :
				`Показатели по плану продаж за ${$month_or_quarter.find('option:selected').text()} ${$year.val()} года :`;
			$('.text-date').append(text_of_date);
			let $main = $('.main');
			for (let user_setting of users_settings) {
				let name = user_setting.name;
				if (user_setting.id in data) {
					let id = user_setting.id;
					let plane_of_overall_product = user_setting.overall_product;
					let plane_of_tare_product = user_setting.tare_product;
					let plane_of_drink_product = user_setting.drink_product;
					let opportunity = 0;
					let overall_product = 0;
					let tare_product = 0;
					let drink_product = 0;
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
					let pct_overall_product = ((100 * overall_product) / plane_of_overall_product).toFixed(2);
					let pct_drink_product = ((100 * drink_product) / plane_of_drink_product).toFixed(2);
					let pct_tare_product = ((100 * tare_product) / plane_of_tare_product).toFixed(2);
					switch ($type_of_product.val()) {
						case 'Общее':
							$main.append(`<div class="d-flex flex-column mb-3">
								<h4 class="name">${name}</h4>
								<label></label>
								<div class="progress mb-3 shadow">
									<div class="progress-bar ${pct_overall_product > 100 ? 'progress-bar-striped progress-bar-animated' : ''}"
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
							</div>`);
							break;
						case 'По категориям товара':
							$main.append(`<div class="d-flex flex-column mb-3">
								<h4 class="name">${name}</h4>
								<label>Пэт-тара</label>
								<div class="progress mb-2 shadow">
									<div class="progress-bar ${pct_tare_product > 100 ? 'progress-bar-striped progress-bar-animated' : ''}"
									 role="progressbar" aria-label="tare_product" style="width: ${pct_tare_product}%;" aria-valuenow="${pct_tare_product}" aria-valuemin="0" aria-valuemax="100">
										${pct_tare_product}%
									</div>
								</div>
								<label>Вода, напитки</label>
								<div class="progress mb-3 shadow">
									<div class="progress-bar ${pct_drink_product > 100 ? 'progress-bar-striped progress-bar-animated' : ''}"
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
							</div>`);
							break;
					}
				} else {
					$main.append(`<div class="d-flex flex-column">
							<h4 class="name">${name}</h4>
							<p class="col-12">Данных по данному сотруднику не обнаруженно.</p>
						</div>`);
				}
			}
		}
	})
}

let $saved_settings = $('#saved_settings');

//получение списка сохраненных настроек
function getListSettings() {
	$saved_settings.find('option').remove();
	$.ajax({
		type: 'POST', url: 'src/getListSettings.php', success: function (response) {
			let data = jQuery.parseJSON(response);
			for (let key in data) {
				let reg = /\.json/;
				if(data[key].match(reg)) {
					data[key] = data[key].replace(reg, '');
				}
				$saved_settings.append(`<option>${data[key]}</option>`);
			}
			$saved_settings.selectpicker('destroy');
			$saved_settings.selectpicker('render');
		}
	})
}