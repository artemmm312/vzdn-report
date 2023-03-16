const months = ["Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь"];

let $month_for_store = $('#month_for_store');

let now_month = new Date().getMonth();

function pushMonths(months) {
	let i = 0;
	for (let month of months) {
		$month_for_store.append(`<option value="${i++}">${month}</option>`);
	}
	$month_for_store.selectpicker('destroy');
	$month_for_store.selectpicker('render');
}

function createTableRB(month) {
	$('#storeTableRB').DataTable({
		language: {url: 'https://cdn.datatables.net/plug-ins/1.10.19/i18n/Russian.json'},
		paging: false,
		searching: false,
		processing: true,
		info: false,
		serverMethod: 'post',
		ajax: {
			url: 'src/handler.php', //источник данных ajax для таблицы
			data: {'month_for_store': month},
			dataSrc: "warehousesRB"
		},
		columnDefs: [
			{targets: [2, 4], render: DataTable.render.number(null, null, 2)},
		],
		columns: [
			{data: 'store'},
			{data: 't_quan', className: "table-primary border-dark"},
			{data: 't_sum', className: "table-success border-dark"},
			{data: 'd_quan', className: "table-primary border-dark"},
			{data: 'd_sum', className: "table-success border-dark"},
		],
		footerCallback: function (tfoot, data, start, end, display) {
			let api = this.api();
			$(api.column(1).footer()).html(
				api.column(1).data().reduce(function (a, b) {
					let sum = Number(a) + Number(b);
					return sum.toFixed(0);
				}, 0)
			);
			$(api.column(2).footer()).html(
				api.column(2).data().reduce(function (a, b) {
					let sum = Number(a) + Number(b);
					return sum.toFixed(2);
				}, 0)
			);
			$(api.column(3).footer()).html(
				api.column(3).data().reduce(function (a, b) {
					let sum = Number(a) + Number(b);
					return sum.toFixed(0);
				}, 0)
			);
			$(api.column(4).footer()).html(
				api.column(4).data().reduce(function (a, b) {
					let sum = Number(a) + Number(b);
					return sum.toFixed(2);
				}, 0)
			)
		}
	});
}

function createTableRF(month) {
	$('#storeTableRF').DataTable({
		language: {url: 'https://cdn.datatables.net/plug-ins/1.10.19/i18n/Russian.json'},
		paging: false,
		searching: false,
		processing: true,
		info: false,
		serverMethod: 'post',
		ajax: {
			url: 'src/handler.php', //источник данных ajax для таблицы
			data: {'month_for_store': month},
			dataSrc: "warehousesRF"
		},
		columnDefs: [
			{targets: [2, 4], render: DataTable.render.number(null, null, 2)},
		],
		columns: [
			{data: 'store'},
			{data: 't_quan', className: "table-primary border-dark"},
			{data: 't_sum', className: "table-success border-dark"},
			{data: 'd_quan', className: "table-primary border-dark"},
			{data: 'd_sum', className: "table-success border-dark"},
		],
		footerCallback: function (tfoot, data, start, end, display) {
		},
	});
}

let tablesStores =
	{
		'store_162-tare': $('#storeTable_162-tare'),
		'store_162-drink': $('#storeTable_162-drink'),
		'store_164-tare': $('#storeTable_164-tare'),
		'store_164-drink': $('#storeTable_164-drink'),
		'store_165-tare': $('#storeTable_165-tare'),
		'store_165-drink': $('#storeTable_165-drink'),
		'store_163-tare': $('#storeTable_163-tare'),
		'store_163-drink': $('#storeTable_163-drink'),
	};

function createTablesProductsStores(tablesStores, month) {
	$.ajax({
		type: 'POST',
		url: 'src/handler.php',
		data: {'month_for_store': month},
		success: function (response) {
			console.log(response);
			for (let table in tablesStores) {
				console.log(table);
				console.log(response[table]);
				console.log(tablesStores[table]);
				tablesStores[table].DataTable({
					language: {url: 'https://cdn.datatables.net/plug-ins/1.10.19/i18n/Russian.json'},
					processing: true,
					serverMethod: 'post',
					data: response[table],
					order: [[1, 'desc']],
					columnDefs: [
						{targets: 2, render: DataTable.render.number(null, null, 2)},
					],
					columns: [
						{data: 'name'},
						{data: 'quan', className: "table-primary"},
						{data: 'sum', className: "table-success"},
					],
				});
			}
		}
	});
}

function test (tablesStores, $month_for_store) {
	for (let table in tablesStores) {
		tablesStores[table].DataTable().destroy();
	}
	createTablesProductsStores(tablesStores, $month_for_store);
}

$(function () {
	pushMonths(months);

	$month_for_store.val(now_month);
	$month_for_store.selectpicker('destroy');
	$month_for_store.selectpicker('render');

	createTableRB(now_month);
	createTableRF(now_month);

	createTablesProductsStores(tablesStores, now_month);

	$month_for_store.on('change', function () {
		console.log($month_for_store.val())
		$('#storeTableRB').DataTable().destroy();
		createTableRB($month_for_store.val());
		$('#storeTableRF').DataTable().destroy();
		createTableRF($month_for_store.val());

		for (let table in tablesStores) {
			tablesStores[table].DataTable().destroy();
		}
		createTablesProductsStores(tablesStores, $month_for_store.val())
	});
});



