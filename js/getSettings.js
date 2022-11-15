let general_settings;
let users_settings;
/*let $month_or_quarter_option = $('#month_or_quarter option').text();
console.log($month_or_quarter_option);*/

//получение данных от сервера
function getSettings() {
	$.ajax({
		type: 'POST', url: 'getSettings.php', success: function (response) {
			let data = jQuery.parseJSON(response);
			general_settings = data[0];
			users_settings = data[1];
			//console.log(users_settings);

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

getSettings();

//дынные для отчета
function test() {
	$.ajax({
		type: 'POST', url: 'handler.php', success: function (response) {
			let data = jQuery.parseJSON(response);
			let text_of_date = $season.val() === 'Год' ? `Показатели по плану продаж за ${$year.val()} год :` : `Показатели по плану продаж за ${$month_or_quarter.find('option:selected').text()} ${$year.val()} года :`;
			$('.text-date').append(text_of_date);
			console.log(data);
			console.log(general_settings);
			console.log(users_settings);
			for (let user_setting of users_settings) {
				console.log(user_setting.id);
				if (user_setting.id in data) {
					let id = user_setting.id;
					let name = user_setting.name;
					let plane_of_tare_product = user_setting.tare_product;
					let plane_of_drink_product = user_setting.drink_product;
					let opportunity = 0;
					let tare_product = 0;
					let drink_product = 0;
					console.log(name);
					for (let i = 0; i < data[id].length; i++) {
						opportunity += +data[id][i].OPPORTUNITY;
						let products = data[id][i].PRODUCTS;
						for (let product of products) {
							if (product.SECTION_ID === "44") {
								tare_product += product.QUANTITY;
							}
							if (product.SECTION_ID === "45") {
								drink_product += product.QUANTITY;
							}
						}
					}
					let pct_drink_product = ((100 * drink_product) / plane_of_drink_product).toFixed(2);
					let pct_tare_product = ((100 * tare_product) / plane_of_tare_product).toFixed(2);

					$('.main').append(`<div class="d-flex flex-column">
								<h4 class="name">${name}</h4>
								<label>Пэт-тара</label>
								<div class="progress mb-3">
									<div class="progress-bar" role="progressbar" aria-label="tare_product" style="width: ${pct_tare_product}%;" aria-valuenow="${pct_tare_product}" aria-valuemin="0" aria-valuemax="100">
									${pct_tare_product}%
									</div>
								</div>
								<label>Вода, напитки</label>
								<div class="progress mb-3">
									<div class="progress-bar" role="progressbar" aria-label="drink_product" style="width: ${pct_drink_product}%;" aria-valuenow="${pct_drink_product}" aria-valuemin="0" aria-valuemax="100">
									${pct_drink_product}%
									</div>
								</div>
						
								<div class="row gy-5">
									<p class="col-3 border text-bg-info">Выполненно по плану "Пэт-тара" : <br>${tare_product} / ${plane_of_tare_product} единиц.</p>
									<p class="col-3 border text-bg-info">Выполненно по плану "Вода, напитки" : <br>${drink_product} / ${plane_of_drink_product} единиц.</p>
									<p class="col-3 border text-bg-warning">Общее количество реализованного товара: <br>${drink_product + tare_product} единиц.</p>
									<p class="col-3 border text-bg-success">На общую сумму: <br>${opportunity} руб.</p>
								</div>
						</div>`);
				} else {
					let name = user_setting.name;

					$('.main').append(`<div class="d-flex flex-column">
							<h4 class="name">${name}</h4>
							<p class="col-12">Данных по данному сотруднику не обнаруженно.</p>
						</div>`);
				}
			}
		}
	})
}

test();

