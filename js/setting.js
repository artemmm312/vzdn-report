let now = new Date(); //текущая дата
let now_year = now.getFullYear(); //текущий год

//Объект для вывода русских названий месяцев в селект
/*const months = {
	"Январь": 0,
	"Февраль": 1,
	"Март": 2,
	"Апрель": 3,
	"Май": 4,
	"Июнь": 5,
	"Июль": 6,
	"Август": 7,
	"Сентябрь": 8,
	"Октябрь": 9,
	"Ноябрь": 10,
	"Декабрь": 11
};*/
//массив месяцев
let months = ["Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь"];
//массив кварталов
const quarter = ['1 квартал', '2 квартал', '3 квартал', '4 квартал'];
//массив диапозона годов +-5 от текущего в селекте
const range_for_years = [-5, -4, -3, -2, -1, 0, 1, 2, 3, 4, 5];

//вывод годов в селект
for (let i of range_for_years) {
	$('.year select').append(`<option value="${now_year + i}">${now_year + i}</option>`);
}

function chose_season(season) {
	switch (season) {
		case 'Месяц':
			$(".month_or_quarter").css("display", "block");
			$('.month_or_quarter select option').remove();
			for (let i in months) {
				$('.month_or_quarter select').append(`<option value="${i}">${months[i]}</option>`);
			}
			$('.month_or_quarter select').selectpicker('destroy');
			$('.month_or_quarter select').selectpicker('render');
			break;
		case 'Квартал':
			$(".month_or_quarter").css("display", "block");
			$('.month_or_quarter select option').remove();
			for (let i in quarter) {
				$('.month_or_quarter select').append(`<option value="${i}">${quarter[i]}</option>`);
			}
			$('.month_or_quarter select').selectpicker('destroy');
			$('.month_or_quarter select').selectpicker('render');
			break;
		case 'Год':
			$(".month_or_quarter").css("display", "none");
			break;
	}
}

//текущее значение выбора периода (месяц, квартал, год)
chose_season($('.season select').val());
//динамичное значение выбора периода (месяц, квартал, год)
$('.season select').on('change', function () {
	chose_season($(this).val());
})


function chose_form(form) {
	switch (form) {
		case 'Общее':
			$(".general").css("display", "block");
			$(".tare").css("display", "none");
			$(".drink").css("display", "none");
			break;
		case 'По категориям товара':
			$(".tare").css("display", "block");
			$(".drink").css("display", "block");
			$(".general").css("display", "none");
			break;
	}
}

//текущее значение выбора категории товаров
chose_form($('.chose-form select').val());
//динамическое сокрытие
$('.chose-form select').on("change", function () {
	chose_form($(this).val());
});

function tt() {
	$.ajax({
		type: 'POST',
		url: 'getSettings.php',
		success: function (response) {
			//console.log(jQuery.parseJSON(response));
			let data = jQuery.parseJSON(response);
			let test = data[0];
			let test2 = data[1];
			console.log(test);
			console.log(test2);
			console.log(test.season);
			//chose_season(test.season);
			console.log($(`#season option[value=${test.season}]`));
			//$(`#season option[value=${test.season}]`).prop('selected', true);
			$('#season').selectpicker('val', test.season);
			chose_season($('#season').val());
			$('#month_or_quarter').selectpicker('val', test.season_range);
			/*$('#month_or_quarter').val(test.season_range).change();
			$('#month_or_quarter').selectpicker('destroy');
			$('#month_or_quarter').selectpicker('render');*/
			$('#year').selectpicker('val', test.year);
			//$('#season').selectpicker('refresh');
			//$('.season select').selectpicker('destroy');
			//$('.season select').selectpicker('render');
		},
	})
}

tt();
//$(document).ready(function () {});

var usersID = [];
var names = [];
var users = [];

// запись в массив порльзовыателей из списка
function pushUsers() {
	users.length = 0;
	let length = $('.user_list li').length;
	for (let i = 0; i < length; i++) {
		users.push({id: $('.user_list li').eq(i).val(), name: $('.user_list li p').eq(i).text()});
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
	let options = {
		'season': $('.season select').val(),
		'season_range': $('.month_or_quarter select').val(),
		'year': $('.year select').val(),
		'form': $('.chose-form select').val(),
	};
	let userData = [];
	for (let key of $('.user_list li')) {
		let date = {
			'id': $(key).val(),
			'name': $(key).find('p').text(),
			'general': $(key).find('#general').val(),
			'tare': $(key).find('#tare').val(),
			'drink': $(key).find('#drink').val(),
		}
		userData.push(date);
	}
	let settings = [options, userData];
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
		$('.user_list').append(`<li class='list-group-item d-flex justify-content-start align-items-center row' id="${usersID[i]}" value="${usersID[i]}">
				<div class='user col-6 d-flex justify-content-between'>
					<button id='closeB' type='button' class='btn-close' aria-label='Close'></button>
					<p class='mb-0 text-center'>${names[i]}</p>
				</div>  
			  <div class='general col-3'>
			    <label for='general' class='form-label mb-0'>Общее</label>
			    <input type='text' class='form-control' id='general'>
			  </div>
			  <div class='tare col-3'>
			    <label for='tare' class='form-label mb-0'>ПЭТ-тара</label>
			    <input type='text' class='form-control' id='tare'>
			  </div>
			  <div class='drink col-3'>
			    <label for='drink' class='form-label mb-0'>Вода, напитки</label>
			    <input type='text' class='form-control' id='drink'>
			  </div>
			</li>`);
	}
	chose_form($('.chose-form select').val());
	names.length = 0;
	$('#Users').selectpicker('deselectAll');
	pushUsers();
	disOption();
	//updateUsers();
});

$('.user_list').on('click', 'li #closeB', function () { //удаление пользователей
	$(this).parent().parent().remove();
	pushUsers();
	disOption();
	//updateUsers();
});

$('#apply').on('click', function () {
	saveSettings();
});

/*function tt() {
	$.ajax({
		type: 'POST',
		url: 'getSettings.php',
		success: function (response) {
			//console.log(jQuery.parseJSON(response));
			let data = jQuery.parseJSON(response);
			let test = data[0];
			let test2 = data[1];
			console.log(test);
			console.log(test2);
			if(test.season === 'Квартал') {
				$('.season select').find(find(`[value=${test.season}]`)).prop('selected');
				/!*$('.season select').selectpicker('destroy');
				$('.season select').selectpicker('render');*!/
			}
		},
	})
}
tt();*/


