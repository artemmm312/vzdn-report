let general_settings;
let users_settings;

//получение данных от сервера
function getSettings(file_name = '') {
	console.log(file_name);
	$.ajax({
		type: 'POST', url: 'readSettings.php', data: {'file_name': file_name}, success: function (response) {
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

getSettings();

//формирование отчета
function reportGeneration() {
	$.ajax({
		type: 'POST', url: 'handler.php', success: function (response) {
			let data = jQuery.parseJSON(response);
			let text_of_date = $season.val() === 'Год' ?
				`Показатели по плану продаж за ${$year.val()} год :` :
				`Показатели по плану продаж за ${$month_or_quarter.find('option:selected').text()} ${$year.val()} года :`;
			$('.text-date').append(text_of_date);
			for (let user_setting of users_settings) {
				let name = user_setting.name;
				if (user_setting.id in data) {
					let id = user_setting.id;
					//let name = user_setting.name;
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
							$('.main').append(`<div class="d-flex flex-column mb-3">
								<h4 class="name">${name}</h4>
								<label></label>
								<div class="progress mb-3 shadow">
									<div class="progress-bar ${pct_overall_product > 100 ? 'progress-bar-striped progress-bar-animated' : ''}" role="progressbar" aria-label="tare_product" style="width: ${pct_overall_product}%;" aria-valuenow="${pct_overall_product}" aria-valuemin="0" aria-valuemax="100">
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
							$('.main').append(`<div class="d-flex flex-column mb-3">
								<h4 class="name">${name}</h4>
								<label>Пэт-тара</label>
								<div class="progress mb-2 shadow">
									<div class="progress-bar ${pct_tare_product > 100 ? 'progress-bar-striped progress-bar-animated' : ''}" role="progressbar" aria-label="tare_product" style="width: ${pct_tare_product}%;" aria-valuenow="${pct_tare_product}" aria-valuemin="0" aria-valuemax="100">
										${pct_tare_product}%
									</div>
								</div>
								<label>Вода, напитки</label>
								<div class="progress mb-3 shadow">
									<div class="progress-bar ${pct_drink_product > 100 ? 'progress-bar-striped progress-bar-animated' : ''}" role="progressbar" aria-label="drink_product" style="width: ${pct_drink_product}%;" aria-valuenow="${pct_drink_product}" aria-valuemin="0" aria-valuemax="100">
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
					$('.main').append(`<div class="d-flex flex-column">
							<h4 class="name">${name}</h4>
							<p class="col-12">Данных по данному сотруднику не обнаруженно.</p>
						</div>`);
				}
			}
		}
	})
}

reportGeneration();
