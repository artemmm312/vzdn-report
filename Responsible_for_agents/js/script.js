const months = ["Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь"];

let $month_agents = $('#month_agents');

let now_month = new Date().getMonth();

function pushMonths(months) {
	let i = 0;
	for (let month of months) {
		$month_agents.append(`<option value="${i++}">${month}</option>`);
	}
	$month_agents.selectpicker('destroy');
	$month_agents.selectpicker('render');
}

function createTable(month)
{
	$('#responsible_for_agents').DataTable({
		language: {url: 'https://cdn.datatables.net/plug-ins/1.10.19/i18n/Russian.json'},
		paging: false,
		searching: false,
		processing: true,
		info: false,
		serverMethod: 'post',
		ajax: {
			url: 'src/handler.php', //источник данных ajax для таблицы
			data: {'month_for_agents': month},
		},
		columnDefs: [
			{targets: [2, 4], render: DataTable.render.number(null, null, 2)},
		],
		columns: [
			{data: 'name'},
			{data: 'quan_all', className: "table-primary border-dark"},
			{data: 'sum_all', className: "table-success border-dark"},
			{data: 'quan', className: "table-primary border-dark"},
			{data: 'sum', className: "table-success border-dark"},

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
			);
		}
	});
}

$(function () {
	pushMonths(months);

	$month_agents.val(now_month);
	$month_agents.selectpicker('destroy');
	$month_agents.selectpicker('render');

	createTable(now_month);

	$month_agents.on('change', function () {
		$('#responsible_for_agents').DataTable().destroy();
		createTable($month_agents.val());
	});
});
