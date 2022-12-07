checkTopUser(userID);

$(document).ready(function () {
	getSettings();

	getListSettings();

	getListPlane();

	loader();

	pushUsers();

	disOption();
});
