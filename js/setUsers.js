$(document).ready(function () {

	var usersID = [];
	var names = [];
	var users = [];

	function pushUsers() {  // запись в массив порльзовыателей из списка
		users.length = 0;
		let length = $('.user_list li').length;
		for (let i = 0; i < length; i++) {
			users.push({id: $('.user_list li').eq(i).val(), name: $('.user_list li p').eq(i).text()});
		}
	}
	pushUsers();

	function disOption() { //отключение пунктов в селекте которые есть в списке
		$('#Users option').prop('disabled', false);
		for (let user of users) {
			$('#Users').find(`[value=${user['id']}]`).prop('disabled', true);
		}
		$('#Users').selectpicker('destroy');
		$('#Users').selectpicker('render');
	}
	disOption();

	function updateUsers() { //обнавление пользователей на сервере
		console.log(users);
		$.ajax({
			type: 'POST',
			url: 'recordUsers.php',
			data: {'users': JSON.stringify(users)},
			success: function (response) {
				console.log(response);
			},
		})
	}

	$('#Users').change(function () { //выбор из селекта
		usersID = $('#Users').val(); //массив id выбранных пользователей
		if (usersID !== undefined) {
			usersID.length > 0 ? $('#addUsers').prop('disabled', false) : $('#addUsers').prop('disabled', true);
		}
	});

	$('#addUsers').on('click', function () {  //добавление в список
		for (let i = 0; i < usersID.length; i++) {
			names.push($(`#Users option[value=${usersID[i]}]`).text()) //массив фио выбранных пользователей
		}
		for (let i = 0; i < names.length; i++) {
			//$('.user_list').append(`<li id="${usersID[i]}" value="${usersID[i]}">${names[i]}<button id="closeB" type="button" class="btn-close" aria-label="Close"></button></li>`);
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
		names.length = 0;
		$('#Users').selectpicker('deselectAll');
		pushUsers();
		console.log(users);
		disOption();
		updateUsers();
	})

	$('.user_list').on('click', 'li #closeB', function () { //удаление пользователей
		$(this).parent().remove();
		pushUsers();
		disOption();
		updateUsers();
	})

});