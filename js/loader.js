
$(document).ready(function () {
	console.log( "document loaded" );
	getSettings();

	getListSettings();

	//await reportGeneration();

	loader();

	pushUsers();

	disOption();

	//await test(userID);
});

async function loader() {
		await reportGeneration();

		await test(userID);
}



/*let top_user = 1;
let main_users = [4, 5, 7];
let main_of_group = [14, 15];
let one_group = [10, 11, 12, 13, 17, 19];

$( window ).on( "load", function() {
	console.log( "window loaded" );
	console.log($('.user_plane_data'));
	$('.user_plane_data').css('display', 'none');
	if(main_users.includes(userID) || top_user === userID) {
		$('.user_plane_data').css('display', 'block');
	} else if(main_of_group.includes(userID)) {
		$(`.user_plane_data [data-id = ${userID}]`).css('display', 'block');
		for (let id of one_group) {
			$(`.user_plane_data [data-id = ${id}]`).css('display', 'block')
		}
	} else if(one_group.includes(userID)) {
		$(`.user_plane_data [data-id = ${userID}]`).css('display', 'block');
	} else {
		$('.user_plane_data').css('display', 'none');
	}
})*/

