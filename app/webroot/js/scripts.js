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
	$('select#status').change(function() {
		var current_color = $('option.status:selected').attr('style');
		$(this).attr('style',current_color);
	});
	$('.Binded').jPicker();
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
jQuery(function($){
	$.jPicker = {
  window: // used to define the position of the popup window only useful in binded mode
  {
    title: null, // any title for the jPicker window itself - displays "Drag Markers To Pick A Color" if left null
    effects:
    {
      type: 'slide', // effect used to show/hide an expandable picker. Acceptable values "slide", "show", "fade"
      speed:
      {
        show: 'slow', // duration of "show" effect. Acceptable values are "fast", "slow", or time in ms
        hide: 'fast' // duration of "hide" effect. Acceptable value are "fast", "slow", or time in ms
      }
    },
    position:
    {
      x: 'screenCenter', // acceptable values "left", "center", "right", "screenCenter", or relative px value
      y: 'top' // acceptable values "top", "bottom", "center", or relative px value
    },
    expandable: false, // default to large static picker - set to true to make an expandable picker (small icon with popup) - set
                       // automatically when binded to input element
    liveUpdate: true, // set false if you want the user to click "OK" before the binded input box updates values (always "true"
                      // for expandable picker)
    alphaSupport: false, // set to true to enable alpha picking
    alphaPrecision: 0, // set decimal precision for alpha percentage display - hex codes do not map directly to percentage
                       // integers - range 0-2
    updateInputColor: true // set to false to prevent binded input colors from changing
  },
  color:
  {
    mode: 'h', // acceptable values "h" (hue), "s" (saturation), "v" (brightness), "r" (red), "g" (green), "b" (blue), "a" (alpha)
    active: new $.jPicker.Color({ hex: 'ffc000' }), // accepts any declared jPicker.Color object or hex string WITH OR WITHOUT '#'
    quickList: // this list of quick pick colors - override for a different list
      [
        new $.jPicker.Color({ h: 360, s: 33, v: 100}), // accepts any declared jPicker.Color object or hex string WITH OR
                                                       // WITHOUT '#'
        new $.jPicker.Color({ h: 360, s: 66, v: 100}),
       // (...) // removed for brevity
        new $.jPicker.Color({ h: 330, s: 100, v: 50}),
        new $.jPicker.Color()
      ]
  },
  images:
  {
    clientPath: '../jPicker/images/', // Path to image files
    colorMap: // colorMap size and arrow icon
    {
      width: 256, // Map width - don't override unless using a smaller image set
      height: 256, // Map height - don't override unles using a smaller image set
      arrow:
      {
        file: 'mappoint.gif', // Arrow icon image file
        width: 15, // Arrow icon width
        height: 15 // Arrow icon height
      }
    },
    colorBar: // colorBar size and arrow icon
    {
      width: 20, // Bar width - don't override unless using a smaller image set
      height: 256, // Bar height - don't override unless using a smaller image set
      arrow:
      {
        file: 'rangearrows.gif', // Arrow icon image file
        width: 40, // Arrow icon width
        height: 9 // Arrow icon height
      }
    },
    picker: // picker icon and size
    {
      file: 'picker.gif', // Picker icon image file
      width: 25, // Picker width - don't override unless using a smaller image set
      height: 24 // Picker height - don't override unless using a smaller image set
    }
  },
  localization: // alter these to change the text presented by the picker (e.g. different language)
  {
    text:
    {
      title: 'Drag Markers To Pick A Color',
      newColor: 'new',
      currentColor: 'current',
      ok: 'OK',
      cancel: 'Cancel'
    },
    tooltips:
    {
      colors:
      {
        newColor: 'New Color - Press “OK” To Commit',
        currentColor: 'Click To Revert To Original Color'
      },
      buttons:
      {
        ok: 'Commit To This Color Selection',
        cancel: 'Cancel And Revert To Original Color'
      },
      hue:
      {
        radio: 'Set To “Hue” Color Mode',
        textbox: 'Enter A “Hue” Value (0-360°)'
      },
      saturation:
      {
        radio: 'Set To “Saturation” Color Mode',
        textbox: 'Enter A “Saturation” Value (0-100%)'
      },
      value:
      {
        radio: 'Set To “Value” Color Mode',
        textbox: 'Enter A “Value” Value (0-100%)'
      },
      red:
      {
        radio: 'Set To “Red” Color Mode',
        textbox: 'Enter A “Red” Value (0-255)'
      },
      green:
      {
        radio: 'Set To “Green” Color Mode',
        textbox: 'Enter A “Green” Value (0-255)'
      },
      blue:
      {
        radio: 'Set To “Blue” Color Mode',
        textbox: 'Enter A “Blue” Value (0-255)'
      },
      alpha:
      {
        radio: 'Set To “Alpha” Color Mode',
        textbox: 'Enter A “Alpha” Value (0-100)'
      },
      hex:
      {
        textbox: 'Enter A “Hex” Color Value (#000000-#ffffff)',
        alpha: 'Enter A “Alpha” Value (#00-#ff)'
      }
    }
  }
	}
}
);
