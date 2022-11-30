checkTopUser(userID);

$(document).ready(function () {
	getSettings();

	getListSettings();

	loader();

	pushUsers();

	disOption();
});
