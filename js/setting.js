let now = new Date(); //текущая дата
let now_year = now.getFullYear(); //текущий год

//массив месяцев
let months = ["Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь"];
//массив кварталов
const quarter = ["1 квартал", "2 квартал", "3 квартал", "4 квартал"];
//массив диапозона годов +-5 от текущего в селекте
const range_for_years = [-5, -4, -3, -2, -1, 0, 1, 2, 3, 4, 5];

let $season = $('#season');
let $month_or_quarter = $('#month_or_quarter');
let $year = $('#year');
let $type_of_product = $('#type_of_product');
let $overall_product = $('#overall_product');
let $tare_product = $('#tare_product');
let $drink_product = $('#drink_product');


//вывод годов в селект
for (let i of range_for_years) {
	$year.append(`<option value="${now_year + i}">${now_year + i}</option>`);
}

function choseSeason(season) {
	switch (season) {
		case 'Месяц':
			$('.month_or_quarter').css('display', 'block');
			$('#month_or_quarter option').remove();
			for (let i in months) {
				$('#month_or_quarter').append(`<option value="${i}">${months[i]}</option>`);
			}
			$('#month_or_quarter').selectpicker('destroy');
			$('#month_or_quarter').selectpicker('render');
			break;
		case 'Квартал':
			$('.month_or_quarter').css('display', 'block');
			$('#month_or_quarter option').remove();
			for (let i in quarter) {
				$("#month_or_quarter").append(`<option value="${i}">${quarter[i]}</option>`);
			}
			$('#month_or_quarter').selectpicker('destroy');
			$('#month_or_quarter').selectpicker('render');
			break;
		case 'Год':
			$('.month_or_quarter').css('display', 'none');
			break;
	}
}

//текущее значение выбора периода (месяц, квартал, год)
choseSeason($('#season').val());
//динамичное значение выбора периода (месяц, квартал, год)
$('#season').on('change', function () {
	choseSeason($(this).val());
})


function choseTypeProduct(type) {
	switch (type) {
		case 'Общее':
			$('.overall_product').css('display', 'block');
			$('.tare_product').css('display', 'none');
			$('.drink_product').css('display', 'none');
			break;
		case 'По категориям товара':
			$('.overall_product').css('display', 'none');
			$('.tare_product').css('display', 'block');
			$('.drink_product').css('display', 'block');
			break;
	}
}

//текущее значение выбора категории товаров
choseTypeProduct($('#type_of_product').val());
//динамическое сокрытие
$('#type_of_product').on('change', function () {
	choseTypeProduct($(this).val());
});

function getSettings() {
	$.ajax({
		type: 'POST',
		url: 'getSettings.php',
		success: function (response) {
			let data = jQuery.parseJSON(response);
			let over_settings = data[0];
			let users_settings = data[1];
			console.log(over_settings);
			console.log(users_settings);

			$('#season').selectpicker('val', over_settings.season);
			choseSeason($('#season').val());
			$('#month_or_quarter').selectpicker('val', over_settings.month_or_quarter);
			$('#year').selectpicker('val', over_settings.year);
			$('#type_of_product').selectpicker('val', over_settings.type_of_product);

			for (let i = 0; i < users_settings.length; i++) {
				$('.users_list').append(`<li class="list-group-item d-flex justify-content-start align-items-center row" id="${users_settings[i].id}" value="${users_settings[i].id}">
				<div class="user col-6 d-flex justify-content-between">
					<button id="deleteUser" type="button" class="btn-close" aria-label="remove user from the list"></button>
					<p class="mb-0 text-center" id="userName">${users_settings[i].name}</p>
				</div>  
			  <div class="overall_product col-3">
			    <label for="overall_product" class="form-label mb-0">Общее</label>
			    <input type="text" class="form-control" id="overall_product" value="${users_settings[i].general}">
			  </div>
			  <div class="tare_product col-3">
			    <label for="tare_product" class="form-label mb-0">ПЭТ-тара</label>
			    <input type="text" class="form-control" id="tare_product" value="${users_settings[i].tare}">
			  </div>
			  <div class="drink_product col-3">
			    <label for="drink_product" class="form-label mb-0">Вода, напитки</label>
			    <input type="text" class="form-control" id="drink_product" value="${users_settings[i].drink}">
			  </div>
			</li>`);
			}
			choseTypeProduct($('#type_of_product').val());
		},
	})
}

getSettings();
//$(document).ready(function () {});

var usersID = [];
var names = [];
var users = [];

// запись в массив порльзовыателей из списка
function pushUsers() {
	users.length = 0;
	let length = $('.users_list li').length;
	for (let i = 0; i < length; i++) {
		users.push({id: $('.users_list li').eq(i).val(), name: $('.users_list li p').eq(i).text()});
	}
}

pushUsers();

//отключение пунктов в селекте которые есть в списке
function disOption() {
	$('#Users option').prop('disabled', false);
	for (let user of users) {
		$('#Users').find(`[value=${user['id']}]`).prop('disabled', true);
	}
	$('#Users').selectpicker('destroy');
	$('#Users').selectpicker('render');
}

disOption();

//сохнанение настроек
function saveSettings() {
	let over_settings = {
		'season': $('#season').val(),
		'month_or_quarter': $('#month_or_quarter').val(),
		'year': $('#year').val(),
		'type_of_product': $('#type_of_product').val(),
	};
	let users_settings = [];
	for (let key of $('.users_list li')) {
		let options = {
			'id': $(key).val(),
			'name': $(key).find('#userName').text(),
			'overall_product': $(key).find('#overall_product').val(),
			'tare_product': $(key).find('#tare_product').val(),
			'drink_product': $(key).find('#drink_product').val(),
		}
		users_settings.push(options);
	}
	let settings = [over_settings, users_settings];
	console.log(settings);
	$.ajax({
		type: 'POST',
		url: 'recordSettings.php',
		data: {'settings': JSON.stringify(settings)},
		success: function (response) {
		},
	})
}

//выбор из селекта и запись id выбранных пользователей
$('#Users').change(function () {
	usersID = $('#Users').val();
	if (usersID !== undefined) {
		usersID.length > 0 ? $('#addUsers').prop('disabled', false) : $('#addUsers').prop('disabled', true);
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
			    <input type="text" class="form-control" id="overall_product">
			  </div>
			  <div class="tare_product col-3">
			    <label for="tare_product" class="form-label mb-0">ПЭТ-тара</label>
			    <input type="text" class="form-control" id="tare_product">
			  </div>
			  <div class="drink_product col-3">
			    <label for="drink_product" class="form-label mb-0">Вода, напитки</label>
			    <input type="text" class="form-control" id="drink_product">
			  </div>
			</li>`);
	}
	choseTypeProduct($('.type_of_product select').val());
	names.length = 0;
	$('#Users').selectpicker('deselectAll');
	pushUsers();
	disOption();
});

//удаление пользователей из списка
$('.users_list').on('click', 'li #deleteUser', function () {
	$(this).parent().parent().remove();
	pushUsers();
	disOption();
});

$('#apply').on('click', function () {
	saveSettings();
});



