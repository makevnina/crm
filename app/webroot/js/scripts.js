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

function open_dialog() {
	$('#dialogform').dialog({modal:true});
}

$(document).ready(function() {
	$('.details_block').hide();
	$(function() {
		$('.datepicker').datepicker($.datepicker.regional["ru"]);
		$( ".datepicker" ).datepicker({ dateFormat: 'yy-mm-dd' });
		$( ".datepicker" ).datepicker( "option", "dateFormat", 'yy-mm-dd' );
	});
	
	$("select").change(function() {
		var current_value = "";
		$('optgroup[label="Клиенты"] option:selected').each(function() {
			current_value = 'client';
		});
		$('optgroup[label="Компании"] option:selected').each(function() {
			current_value = 'company';
		});
		$('#artifact_type').attr('value', current_value);
	});
});
jQuery(function($){
	$.datepicker.regional['ru'] = {
		closeText: 'Закрыть',
		prevText: '&#x3c;Пред',
		nextText: 'След&#x3e;',
		currentText: 'Сегодня',
		monthNames: ['Январь','Февраль','Март','Апрель','Май','Июнь',
		'Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'],
		monthNamesShort: ['Янв','Фев','Мар','Апр','Май','Июн',
		'Июл','Авг','Сен','Окт','Ноя','Дек'],
		dayNames: ['воскресенье','понедельник','вторник','среда','четверг','пятница','суббота'],
		dayNamesShort: ['вск','пнд','втр','срд','чтв','птн','сбт'],
		dayNamesMin: ['Вс','Пн','Вт','Ср','Чт','Пт','Сб'],
		weekHeader: 'Не',
		dateFormat: 'dd.mm.yy',
		firstDay: 1,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ''};
	$.datepicker.setDefaults($.datepicker.regional['ru']);
});

