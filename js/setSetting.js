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

choseSeason($season.val());
$season.on('change', function () {
	choseSeason($(this).val());
})

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

choseTypeProduct($type_of_product.val());
$type_of_product.on('change', function () {
	choseTypeProduct($(this).val());
});

//$(document).ready(function () {});

let usersID = [];
let names = [];
let users = [];
let $Users = $('#Users');

$(document).ready(function () {

// запись в массив порльзовыателей из списка
	function pushUsers() {
		users.length = 0;
		for (let key of $('.users_list li')) {
			users.push({'id': $(key).val(), 'name': $(key).find('#userName').text()});
		}
	}

	pushUsers();

//отключение пунктов в селекте которые есть в списке
	function disOption() {
		$Users.find('option').prop('disabled', false);
		for (let user of users) {
			$Users.find(`[value=${user['id']}]`).prop('disabled', true);
		}
		$Users.selectpicker('destroy');
		$Users.selectpicker('render');
	}

	disOption();

//выбор из селекта и запись id выбранных пользователей
	$Users.change(function () {
		usersID = $(this).val();
		//активация и деактивация кнопки добавления пользователей
		let $addUsers = $('#addUsers');
		if (usersID !== undefined) {
			usersID.length > 0 ? $addUsers.prop('disabled', false) : $addUsers.prop('disabled', true);
		}
	});

//формирование списка из выбранных пользователей
	$('#addUsers').on('click', function () {
		for (let i = 0; i < usersID.length; i++) {
			names.push($(`#Users option[value=${usersID[i]}]`).text()) //массив фио выбранных пользователей
		}
		for (let i = 0; i < names.length; i++) {
			$('.users_list').append(`<li class="list-group-item d-flex justify-content-start align-items-center row" id="${usersID[i]}" value="${usersID[i]}">
				<div class="user col-6 d-flex justify-content-between">
					<button id="deleteUser" type="button" class="btn-close" aria-label="remove user from the list"></button>
					<p class="mb-0 text-center" id="userName">${names[i]}</p>
				</div>  
			  <div class="overall_product col-3">
			    <label for="overall_product" class="form-label mb-0">Общее</label>
			    <input type="number" class="form-control" id="overall_product" value="0" min="0">
			  </div>
			  <div class="tare_product col-3">
			    <label for="tare_product" class="form-label mb-0">ПЭТ-тара</label>
			    <input type="number" class="form-control" id="tare_product" value="0" min="0">
			  </div>
			  <div class="drink_product col-3">
			    <label for="drink_product" class="form-label mb-0">Вода, напитки</label>
			    <input type="number" class="form-control" id="drink_product" value="0" min="0">
			  </div>
			</li>`);
		}
		choseTypeProduct($type_of_product.val());
		names.length = 0;
		$Users.selectpicker('deselectAll');
		pushUsers();
		disOption();
	});

//удаление пользователей из списка
	$('.users_list').on('click', 'li #deleteUser', function () {
		$(this).parent().parent().remove();
		pushUsers();
		disOption();
	});

});

/*//получение данных от сервера
function getSettings() {
	$.ajax({
		type: 'POST',
		url: 'readSettings.php',
		success: function (response) {
			let data = jQuery.parseJSON(response);
			let general_settings = data[0];
			let users_settings = data[1];

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
			    <input type="text" class="form-control" id="overall_product" value="${users_settings[i].overall_product}">
			  </div>
			  <div class="tare_product col-3">
			    <label for="tare_product" class="form-label mb-0">ПЭТ-тара</label>
			    <input type="text" class="form-control" id="tare_product" value="${users_settings[i].tare_product}">
			  </div>
			  <div class="drink_product col-3">
			    <label for="drink_product" class="form-label mb-0">Вода, напитки</label>
			    <input type="text" class="form-control" id="drink_product" value="${users_settings[i].drink_product}">
			  </div>
			</li>`);
			}
			choseTypeProduct($type_of_product.val());
		},
	})
}

getSettings();*/

//сохнанение настроек
function saveSettings() {
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
	console.log(settings);
	$.ajax({
		type: 'POST',
		url: 'recordSettings.php',
		data: {'settings': JSON.stringify(settings)},
		success: function (response) {
		},
	})
}

$('#apply').on('click', function () {
	saveSettings();
	location.reload();
});



