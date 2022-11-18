$(document).ready(function () {

	function getListSettings() {
		$.ajax({
			type: 'POST', url: 'getListSettings.php', success: function (response) {
				let data = jQuery.parseJSON(response);
				console.log(data);
				for (let key in data) {
					let reg = /\.json/;
					if(data[key].match(reg)) {
						data[key] = data[key].replace(reg, '');
					}
					$('#saved-settings').append(`<option>${data[key]}</option>`);
				}
				$('#saved-settings').selectpicker('destroy');
				$('#saved-settings').selectpicker('render');
			}
		})
	}

	getListSettings();

	$('#clear-save').on('click', function () {
		$('#saved-settings').selectpicker('val', '');
	});

	$('#load-save').on('click', function () {
		let file_name = $('#saved-settings').val();
		console.log(file_name);
		getSettings(file_name);
	});


	$('#save-name').on('change keyup input click', function () {
		let reg = /[!@#$%^&*()_?<>"'`~;\/\\\[\]|]/g;
		if ($(this).val().match(reg)) {
			let text = $(this).val().replace(reg, '');
			$(this).val(text);
		}
	});

	$('#push-save').on('click', function () {
		let file_name = $('#save-name').val();
		console.log(file_name);
		saveSettings(file_name);
	});

});