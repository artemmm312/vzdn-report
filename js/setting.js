let now = new Date(); //текущая дата
let now_month = now.getMonth(); //текущий месяц
let now_year = now.getFullYear(); //текущий год

//Объект для вывода русских названий месяцев в селект
let months = {
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
};
//массив диапозона годов +-5 от текущего в селекте
let range_for_years = [-5, -4, -3, -2, -1, 0, 1, 2, 3, 4, 5];

//вывод месяцев в селект
for (let key in months) {
	if (months[key] === now_month) {
		$('.month select').append(`<option value="${months[key]}" selected>${key}</option>`);
	} else {
		$('.month select').append(`<option value="${months[key]}">${key}</option>`);
	}
}

//вывод годов в селект
for (let i of range_for_years) {
	if (now_year + i === now_year) {
		$('.year select').append(`<option value="${now_year + i}" selected>${now_year + i}</option>`);
	} else {
		$('.year select').append(`<option value="${now_year + i}">${now_year + i}</option>`);
	}
}

//текущее значение выбора периода (месяц, квартал, год)
let chose_season = $('.season select').val();

//Сокрытие селектов при определенном значении селекта периода
if (chose_season === 'Месяц') {
	$(".month").css("display", "block");
	$(".quarter").css("display", "none");
}
if (chose_season === 'Квартал') {
	$(".quarter").css("display", "block");
	$(".month").css("display", "none");
}
$('.season select').on("change",function() {
	if($(this).val() === 'Месяц') {
		$(".month").css("display", "block");
		$(".quarter").css("display", "none");
	}
	if($(this).val() === 'Квартал') {
		$(".quarter").css("display", "block");
		$(".month").css("display", "none");
	}
	if($(this).val() === 'Год') {
		$(".quarter").css("display", "none");
		$(".month").css("display", "none");
	}
});

//Сокрытие селектов при определенном значении селекта категории товаров
let chose_form = $('.chose-form select').val();
if(chose_form === 'Общее') {
	$(".general").css("display", "block");
$(".tare").css("display", "none");
$(".drink").css("display", "none");
}
if(chose_form === 'По категориям товара') {
	$(".tare").css("display", "block");
	$(".drink").css("display", "block");
	$(".general").css("display", "none");
}

$('.chose-form select').on("change",function() {
	if($(this).val() === 'Общее') {
		$(".general").css("display", "block");
		$(".tare").css("display", "none");
		$(".drink").css("display", "none");
	}
	if($(this).val() === 'По категориям товара') {
		$(".tare").css("display", "block");
		$(".drink").css("display", "block");
		$(".general").css("display", "none");
	}
});



