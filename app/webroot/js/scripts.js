function add_phone() {
	var phone_field = $('div.phone_block div.input:first-child').clone();
	phone_field.find('input').val('');
	phone_field.find('input').attr('name', 'data[Phone][new][]');
	$('div.phone_block div.input:first-child').after(phone_field);
	return false;
}
function hide_details(block_id) {
	$("#block_" + block_id).hide();
}
function show_details(block_id) {
	$("#block_" + block_id).show();
}


