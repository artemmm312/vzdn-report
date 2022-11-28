
//кнопка очистить выбор селекта сохранённых настроек
$clear_save = $('#clear_save');
//кнопка загрузить выбранную настройку в селекте сохранённых настроек
$load_save = $('#load_save');
//кнопка удалить выбранную настройку в селекте сохранённых настроек
$delete_save = $('#delete_save');

//отключение кнопок очистить, загрузить, удалить если в селекте сохранённых настроек ничего не выбрано
if ($saved_settings.val() === null) {
	$clear_save.prop('disabled', true);
	$load_save.prop('disabled', true);
	$delete_save.prop('disabled', true);
}

//включение кнопок очистить, загрузить, удалить при выборе в селекте сохранённых настроек
$saved_settings.on('change', function () {
		$clear_save.prop('disabled', false);
		$load_save.prop('disabled', false);
		$delete_save.prop('disabled', false);
})

//кнопка очистки выбора сохранённой настройки
$clear_save.on('click', function () {
	$saved_settings.selectpicker('val', '');
	$(this).prop('disabled', true);
	$load_save.prop('disabled', true);
	$delete_save.prop('disabled', true);
});

//кнопка загрузки выбранной настройки из списка сохранённых
$load_save.on('click', function () {
	let file_name = $saved_settings.val();
	$('.users_list li').remove();
	getSettings(file_name);
});

//кнопка удаления выбранной настройки из списка сохранённых
$delete_save.on('click', function () {
	let file_name = $saved_settings.val()
	$('#deletion_text').text(`Вы действительно хотите удалить сохраненный план - ${file_name}`);
	$('#delete_file').one('click', function () {
		$.ajax({
			type: 'POST', url: 'src/deleteSettings.php', data: {'file_name': file_name}, success: function (response) {
			}
		});
		getListSettings();
	});
});

//событие выбора в селекте месяц/квартал/год
$season.on('change', function () {
	choseSeason($(this).val());
})

//событие выбора плана
$type_of_plane.on('change', function () {
	choseTypePlane($(this).val());
})

//событие выбора в селекте типа продуктов
$type_of_product.on('change', function () {
	choseTypeProduct($(this).val());
});

//выбор из селекта и запись id выбранных пользователей
$Users.on('change', function () {
	usersID = $(this).val();
	//активация и деактивация кнопки добавления пользователей
	let $addUsers = $('#addUsers');
	if (usersID !== undefined) {
		usersID.length > 0 ? $addUsers.prop('disabled', false) : $addUsers.prop('disabled', true);
	}
});

//кнопка добавления и формирование списка из выбранных пользователей
$('#addUsers').on('click', function () {
	for (let i = 0; i < usersID.length; i++) {
		names.push($(`#Users option[value=${usersID[i]}]`).text()) //массив фио выбранных пользователей
	}
	for (let i = 0; i < names.length; i++) {
		$('.users_list').append(`<li class="list-group-item row d-flex justify-content-start align-items-center" id="${usersID[i]}" value="${usersID[i]}">
				<div class="user col-6 d-flex justify-content-between">
					<button class="btn-close" id="deleteUser" type="button" aria-label="remove user from the list"></button>
					<p class="mb-0 text-center" id="userName">${names[i]}</p>
				</div>  
			  <div class="overall_product col-3">
			    <label class="form-label mb-0" for="overall_product" >Общее</label>
			    <input class="form-control" id="overall_product" type="number" value="0" min="0">
			  </div>
			  <div class="tare_product col-3">
			    <label class="form-label mb-0" for="tare_product">ПЭТ-тара</label>
			    <input class="form-control" id="tare_product" type="number" value="0" min="0">
			  </div>
			  <div class="drink_product col-3">
			    <label class="form-label mb-0" for="drink_product">Вода, напитки</label>
			    <input class="form-control" id="drink_product" type="number" value="0" min="0">
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

//кнопка применения настроек
$('#apply').on('click', function () {
	saveSettings();
	location.reload();
});

//инпут ввода имени сохраняемой настройки
$saved_name = $('#saved_name');

//дефолтное значение поля ввода имени сохраняемой настройки
$('#save').on('click', function () {
	if($season.val() === 'Месяц' || $season.val() === 'Квартал') {
		$saved_name.val(`${$month_or_quarter.find('option:selected').text()} ${$year.val()}`);

	} else if($season.val() === 'Год') {
		$saved_name.val(`${$year.val()}`)
	}
});

//отключение кнопки сохранения пока название пустое
if($saved_name.val() === '') {
	$('#push_save').prop('disabled', true);
}

//проверка поля ввода имени сохраняемой настройки
$saved_name.on('change keyup input click', function () {
	let reg = /[!@#$%^&*()_?<>"'`~;\/\\\[\]|]/g;
	if ($(this).val().match(reg)) {
		let text = $(this).val().replace(reg, '');
		$(this).val(text);
	}
	if($(this).val() !== '') {
		$('#push_save').prop('disabled', false);
	} else {
		$('#push_save').prop('disabled', true);
	}
});

//кнопка сохранения настройки
$('#push_save').on('click', function () {
	let file_name = $('#saved_name').val();
	saveSettings(file_name);
	getListSettings();
	$saved_settings.selectpicker('val', file_name);
});
