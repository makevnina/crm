function add_phone() {
	var phone_field = $('div.phone_block div.input:first-child').clone();
	phone_field.find('input').val('');
	phone_field.find('input').attr('name', 'data[Phone][new][]');
	$('div.phone_block div.input:first-child').after(phone_field);
	return false;
}

function add_email() {
	var email_field = $('div.email_block div.input:first-child').clone();
	email_field.find('input').val('');
	email_field.find('input').attr('name', 'data[Email][new][]');
	$('div.email_block div.input:first-child').after(email_field);
	return false;
}
function toggle_details(block_id) {
	if ($(".block" + block_id).is(":visible")) {
		$(".block" + block_id).hide();
		return false;
	}	
	if ($(".block" + block_id).is(":hidden")) {
		$(".block" + block_id).show();
		return false;
	}
}

$(document).ready(function() {
	$('.details_block').hide();
});

