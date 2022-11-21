let $saved_settings = $('#saved_settings');

$(document).ready(function () {

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

	getListSettings();

	//кнопака очистки выбора сохранённой настройки
	$('#clear_save').on('click', function () {
		$saved_settings.selectpicker('val', '');
	});

	//кнопка загрузки выбранной настройки из списка сохранённых
	$('#load_save').on('click', function () {
		let file_name = $saved_settings.val();
		$('.users_list li').remove();
		getSettings(file_name);
	});

	//кнопка удаления выбранной настройки из списка сохранённых
	$('#delete_save').on('click', function () {
		let file_name = $saved_settings.val()
		$('#deletion_text').text(`Вы действительно хотите удалить сохраненный план - ${file_name}`);
		$('#delete_file').one('click', function () {
			$.ajax({
				type: 'POST', url: 'src/deleteSettings.php', data: {'file_name': file_name}, success: function (response) {}
			});
			getListSettings();
		});
	});

	//проверкаа поля ввода имени сохраняемой настройки
	$('#saved_name').on('change keyup input click', function () {
		let reg = /[!@#$%^&*()_?<>"'`~;\/\\\[\]|]/g;
		if ($(this).val().match(reg)) {
			let text = $(this).val().replace(reg, '');
			$(this).val(text);
		}
	});

	//кнопка сохранения настройки
	$('#push_save').on('click', function () {
		let file_name = $('#saved_name').val();
		saveSettings(file_name);
		getListSettings();
		$saved_settings.selectpicker('val', file_name);
	});
});