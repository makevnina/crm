$('a.add_phone').live('click', function(){
	var field = $(this).parent().find('div.input').first().clone();
	field.find('input').val('');
	field.find('input').attr('name', 'data[Phone][new][]');
	$(this).parent().find('div.input').last().after(field);
	return false;
});
$('a.add_email').live('click', function(){
	var field = $(this).parent().find('div.input').first().clone();
	field.find('input').val('');
	field.find('input').attr('name', 'data[Email][new][]');
	$(this).parent().find('div.input').last().after(field);
	return false;
});

$(function() {
	$( "#sortable" ).sortable();
	$( "#sortable" ).disableSelection();
});

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

function deleteClient(id) {
	var agree = false;
	if (confirm('Вы действительно хотите удалить клиента?')) {
		if (confirm('Удалить задачи и проекты, связанные с клиентом?')) {
			agree = true;
		}
		parent.location = '/clients/delete/' + id + '/' + agree;
	}
}

function deleteCompany(id) {
	var clientAgree = false;
	var projectAgree = false;
	if (confirm('Вы действительно хотите удалить компанию?')) {
		if (confirm('Удалить контактных лиц данной компании?')) {
			clientAgree = true;
		}
		if (confirm('Удалить проекты данной компании?')) {
			projectAgree = true;
		}
		parent.location = '/companies/delete/' + id + '/' + clientAgree + '/' + projectAgree;
	}
}

function deleteTask(id) {
	if (confirm('Вы действительно хотите удалить задачу?')) {
		parent.location = '/tasks/delete/' + id;
	}
}

function deleteProject(id) {
	var agree = false;
	if (confirm('Вы действительно хотите удалить проект?')) {
		if (confirm('Удалить задачи, связанные с проектом?')) {
			agree = true;
		}
		parent.location = '/projects/delete/' + id + '/' + agree;
	}
}

function deleteUser(id) {
	if (confirm('Вы действительно хотите удалить пользователя?')) {
		parent.location = '/users/delete/' + id;
	}
}

function create_company_dialog() {
	var dialog = $('<div style="display:none" class="loading"></div>').appendTo('body');
	// open the dialog
	dialog.dialog({
		// add a close listener to prevent adding multiple divs to the document
		close: function(event, ui) {
			// remove div with all data and events
			dialog.remove();
		},
		modal: true,
		position: 'top',
		width: 500
	});
	var url = '/companies/create';
	dialog.load(
		url, 
		{}, // omit this param object to issue a GET request instead a POST request, otherwise you may provide post parameters within the object
		function (responseText, textStatus, XMLHttpRequest) {
			// remove the loading class
			dialog.removeClass('loading');
			$('#clientSelect').parent().remove();
			
			var initForm = function() {
				var form = $('#CompanyCreateForm');
				form.submit(function(){
					$.ajax({
						url: form.attr('action'),
						type: form.attr('method'),
						data: form.serialize(),
						beforeSend: function() {
							dialog.addClass('loading');
						},
						complete: function(jqXHR, textStatus) {
							dialog.removeClass('loading');
							if ('application/json' == jqXHR.getResponseHeader('Content-type')) {
								var company = $.parseJSON(jqXHR.responseText);
								$('#ClientCompanyId').append(
									$('<option />')
										.val(company.Company.id)
										.text(company.Company.name)
								)
									.val(company.Company.id);
								dialog.remove();
							}
							else {
								dialog.html(jqXHR.responseText);
								initForm();
								$('#clientSelect').parent().remove();
							}
						}
					});
					return false;
				});
			};
			initForm();
		}
	);
	//prevent the browser to follow the link
	return false;
}

function create_client_dialog() {
	var dialog = $('<div style="display:none" class="loading"></div>').appendTo('body');
	// open the dialog
	dialog.dialog({
		// add a close listener to prevent adding multiple divs to the document
		close: function(event, ui) {
			// remove div with all data and events
			dialog.remove();
		},
		modal: true,
		position: 'top',
		width: 500
	});
	var url = '/clients/create';
	dialog.load(
		url, 
		{}, // omit this param object to issue a GET request instead a POST request, otherwise you may provide post parameters within the object
		function (responseText, textStatus, XMLHttpRequest) {
			// remove the loading class
			dialog.removeClass('loading');
			$('#ClientCompanyId').parent().remove();
			$('#CreateNewCompanyLink').remove();
			
			var initForm = function() {
				var form = $('#ClientCreateForm');
				form.submit(function(){
					$.ajax({
						url: form.attr('action'),
						type: form.attr('method'),
						data: form.serialize(),
						beforeSend: function() {
							dialog.addClass('loading');
						},
						complete: function(jqXHR, textStatus) {
							dialog.removeClass('loading');
							if ('application/json' == jqXHR.getResponseHeader('Content-type')) {
								var client = $.parseJSON(jqXHR.responseText);
								$('#clientSelect').append(
									$('<option />')
										.val(client.Client.id)
										.text([client.Client.name, client.Client.surname, client.Client.father].join(' '))
								);
								var selectedClients = $('#clientSelect').val() || [];
								$('#clientSelect').val(
									$.merge(selectedClients, [client.Client.id])
								);
								dialog.remove();
							}
							else {
								dialog.html(jqXHR.responseText);
								initForm();
								$('#clientSelect').parent().remove();
							}
						}
					});
					return false;
				});
			};
			initForm();
		}
	);
	//prevent the browser to follow the link
	return false;
}

$(document).ready(function() {
	$('.details_block').hide();
	
	$(function() {
//		$('.datepicker').datepicker($.datepicker.regional["ru"]);
		$( ".datepicker" ).datetimepicker({
			dateFormat: 'yy-mm-dd',
			timeFormat: 'hh:mm:ss',
			showSecond: true
		});
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
	
	$('select#status').change(function() {
		var current_color = $('option.status:selected').attr('style');
		$(this).attr('style',current_color);
	});
	
	var amountStatus = $('.hiddenStatusColor').length;
	for (i = 0; i <= amountStatus; i++) {
		var current_color = $('#block'+i).attr('value');
		$('#color'+i).jPicker(
		{
			window:
				{
				title: 'Перетащите маркер, чтоб выбрать цвет',
				position:
					{
					x: 'screenCenter',
					y: 'screenCenter'
					},
				expandable: true
				},
			color:
				{
				active: new $.jPicker.Color({ahex: current_color})
				}
		},
		function(color, context) {
			var all = color.val('all');
			var status_color = '#'+all.hex;	
			var block_class = '.'+$(this).attr('id');
			$(block_class).attr('value', status_color);
		}
		);	
	}
	$('#ProjectDiv option').hide();
	$('#ProjectDiv option[id="emptyOption"]').show();
	$("#ProjectDiv option[class="+$('#ClientSelect option:selected').attr('class')+"]").show();
	$('#ClientSelect').change(function() {
		$('#ProjectDiv option').hide();
		$('#ProjectDiv option[id="emptyOption"]').attr('selected', 'selected');		
		$('#ProjectDiv option[id="emptyOption"]').show();
		$("#ProjectDiv option[class="+$('#ClientSelect option:selected').attr('class')+"]").show();
	});
	
	$('#ProjectStatusStagesForm').submit(function(){
		var result = $('#sortable').sortable('toArray');
		$.ajax({
			type: 'POST',
			url: '/reports/stages',
			data: {
				data: {sort: result}
			}
		});

		return false;
	});

  $('#ClientSource').editableSelect();

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
