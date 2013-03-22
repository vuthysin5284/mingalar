

(function($) { 


function TimeEntry() {
	this._disabledInputs = []; 
	this.regional = []; 
	this.regional[''] = {
		show24Hours: false, 
		separator: ':', 
		ampmPrefix: '', 
		ampmNames: ['AM', 'PM'], 
		spinnerTexts: ['Now', 'Previous field', 'Next field', 'Increment', 'Decrement']
		
	};
	this._defaults = {
		appendText: '', 
		showSeconds: false, 
		timeSteps: [1, 1, 1], 
		initialField: 0, 
		useMouseWheel: true,
			
		defaultTime: null,
		minTime: null,
		maxTime: null, 
		spinnerImage: 'spinnerDefault.png', 
			
		spinnerSize: [20, 20, 8], 
			
		spinnerBigImage: '', 
			
		spinnerBigSize: [40, 40, 16], 
			
		spinnerIncDecOnly: false, 
		spinnerRepeat: [500, 250], 
		
		beforeShow: null,
		
		beforeSetTime: null 
	};
	$.extend(this._defaults, this.regional['']);
}

var PROP_NAME = 'timeEntry';

$.extend(TimeEntry.prototype, {
	
	markerClassName: 'hasTimeEntry',

	
	setDefaults: function(options) {
		extendRemove(this._defaults, options || {});
		return this;
	},


	_connectTimeEntry: function(target, options) {
		var input = $(target);
		if (input.hasClass(this.markerClassName)) {
			return;
		}
		var inst = {};
		inst.options = $.extend({}, options);
		inst._selectedHour = 0; 
		inst._selectedMinute = 0; 
		inst._selectedSecond = 0; 
		inst._field = 0;
		inst.input = $(target); 
		$.data(target, PROP_NAME, inst);
		var spinnerImage = this._get(inst, 'spinnerImage');
		var spinnerText = this._get(inst, 'spinnerText');
		var spinnerSize = this._get(inst, 'spinnerSize');
		var appendText = this._get(inst, 'appendText');
		var spinner = (!spinnerImage ? null : 
			$('<span class="timeEntry_control" style="display: inline-block; ' +
			'background: url(\'' + spinnerImage + '\') 0 0 no-repeat; ' +
			'width: ' + spinnerSize[0] + 'px; height: ' + spinnerSize[1] + 'px;' +
			($.browser.mozilla && $.browser.version < '1.9' ? 
			' padding-left: ' + spinnerSize[0] + 'px; padding-bottom: ' +
			(spinnerSize[1] - 18) + 'px;' : '') + '"></span>'));
		input.wrap('<span class="timeEntry_wrap"></span>').
			after(appendText ? '<span class="timeEntry_append">' + appendText + '</span>' : '').
			after(spinner || '');
		input.addClass(this.markerClassName).bind('focus.timeEntry', this._doFocus).
			bind('blur.timeEntry', this._doBlur).bind('click.timeEntry', this._doClick).
			bind('keydown.timeEntry', this._doKeyDown).bind('keypress.timeEntry', this._doKeyPress);
		
		if ($.browser.mozilla) {
			input.bind('input.timeEntry', function(event) { $.timeEntry._parseTime(inst); });
		}
		if ($.browser.msie) {
			input.bind('paste.timeEntry', 
				function(event) { setTimeout(function() { $.timeEntry._parseTime(inst); }, 1); });
		}
		
		if (this._get(inst, 'useMouseWheel') && $.fn.mousewheel) {
			input.mousewheel(this._doMouseWheel);
		}
		if (spinner) {
			spinner.mousedown(this._handleSpinner).mouseup(this._endSpinner).
				mouseover(this._expandSpinner).mouseout(this._endSpinner).
				mousemove(this._describeSpinner);
		}
	},

	
	_enableTimeEntry: function(input) {
		this._enableDisable(input, false);
	},

	
	_disableTimeEntry: function(input) {
		this._enableDisable(input, true);
	},

	
	_enableDisable: function(input, disable) {
		var inst = $.data(input, PROP_NAME);
		if (!inst) {
			return;
		}
		input.disabled = disable;
		if (input.nextSibling && input.nextSibling.nodeName.toLowerCase() == 'span') {
			$.timeEntry._changeSpinner(inst, input.nextSibling, (disable ? 5 : -1));
		}
		$.timeEntry._disabledInputs = $.map($.timeEntry._disabledInputs,
			function(value) { return (value == input ? null : value); }); 
		if (disable) {
			$.timeEntry._disabledInputs.push(input);
		}
	},

	
	_isDisabledTimeEntry: function(input) {
		return $.inArray(input, this._disabledInputs) > -1;
	},


	_changeTimeEntry: function(input, options, value) {
		var inst = $.data(input, PROP_NAME);
		if (inst) {
			if (typeof options == 'string') {
				var name = options;
				options = {};
				options[name] = value;
			}
			var currentTime = this._extractTime(inst);
			extendRemove(inst.options, options || {});
			if (currentTime) {
				this._setTime(inst, new Date(0, 0, 0,
					currentTime[0], currentTime[1], currentTime[2]));
			}
		}
		$.data(input, PROP_NAME, inst);
	},

	
	_destroyTimeEntry: function(input) {
		$input = $(input);
		if (!$input.hasClass(this.markerClassName)) {
			return;
		}
		$input.removeClass(this.markerClassName).unbind('.timeEntry');
		if ($.fn.mousewheel) {
			$input.unmousewheel();
		}
		this._disabledInputs = $.map(this._disabledInputs,
			function(value) { return (value == input ? null : value); }); 
		$input.parent().replaceWith($input);
		$.removeData(input, PROP_NAME);
	},

	
	_setTimeTimeEntry: function(input, time) {
		var inst = $.data(input, PROP_NAME);
		if (inst) {
			this._setTime(inst, time ? (typeof time == 'object' ?
				new Date(time.getTime()) : time) : null);
		}
	},

	/* Retrieve the current time for a time entry input field.
	   @param  input  (element) input field to examine
	   @return  (Date) current time (year/month/day zero) or null if none */
	_getTimeTimeEntry: function(input) {
		var inst = $.data(input, PROP_NAME);
		var currentTime = (inst ? this._extractTime(inst) : null);
		return (!currentTime ? null :
			new Date(0, 0, 0, currentTime[0], currentTime[1], currentTime[2]));
	},

	/* Retrieve the millisecond offset for the current time.
	   @param  input  (element) input field to examine
	   @return  (number) the time as milliseconds offset or zero if none */
	_getOffsetTimeEntry: function(input) {
		var inst = $.data(input, PROP_NAME);
		var currentTime = (inst ? this._extractTime(inst) : null);
		return (!currentTime ? 0 :
			(currentTime[0] * 3600 + currentTime[1] * 60 + currentTime[2]) * 1000);
	},

	/* Initialise time entry.
	   @param  target  (element) the input field or
	                   (event) the focus event */
	_doFocus: function(target) {
		var input = (target.nodeName && target.nodeName.toLowerCase() == 'input' ? target : this);
		if ($.timeEntry._lastInput == input || $.timeEntry._isDisabledTimeEntry(input)) {
			$.timeEntry._focussed = false;
			return;
		}
		var inst = $.data(input, PROP_NAME);
		$.timeEntry._focussed = true;
		$.timeEntry._lastInput = input;
		$.timeEntry._blurredInput = null;
		var beforeShow = $.timeEntry._get(inst, 'beforeShow');
		extendRemove(inst.options, (beforeShow ? beforeShow.apply(input, [input]) : {}));
		$.data(input, PROP_NAME, inst);
		$.timeEntry._parseTime(inst);
		setTimeout(function() { $.timeEntry._showField(inst); }, 10);
	},

	/* Note that the field has been exited.
	   @param  event  (event) the blur event */
	_doBlur: function(event) {
		$.timeEntry._blurredInput = $.timeEntry._lastInput;
		$.timeEntry._lastInput = null;
	},

	/* Select appropriate field portion on click, if already in the field.
	   @param  event  (event) the click event */
	_doClick: function(event) {
		var input = event.target;
		var inst = $.data(input, PROP_NAME);
		if (!$.timeEntry._focussed) {
			var fieldSize = $.timeEntry._get(inst, 'separator').length + 2;
			inst._field = 0;
			if (input.selectionStart != null) { 
				for (var field = 0; field <= Math.max(1, inst._secondField, inst._ampmField); field++) {
					var end = (field != inst._ampmField ? (field * fieldSize) + 2 :
						(inst._ampmField * fieldSize) + $.timeEntry._get(inst, 'ampmPrefix').length +
						$.timeEntry._get(inst, 'ampmNames')[0].length);
					inst._field = field;
					if (input.selectionStart < end) {
						break;
					}
				}
			}
			else if (input.createTextRange) { 
				var src = $(event.srcElement);
				var range = input.createTextRange();
				var convert = function(value) {
					return {thin: 2, medium: 4, thick: 6}[value] || value;
				};
				var offsetX = event.clientX + document.documentElement.scrollLeft -
					(src.offset().left + parseInt(convert(src.css('border-left-width')), 10)) -
					range.offsetLeft; 
				for (var field = 0; field <= Math.max(1, inst._secondField, inst._ampmField); field++) {
					var end = (field != inst._ampmField ? (field * fieldSize) + 2 :
						(inst._ampmField * fieldSize) + $.timeEntry._get(inst, 'ampmPrefix').length +
						$.timeEntry._get(inst, 'ampmNames')[0].length);
					range.collapse();
					range.moveEnd('character', end);
					inst._field = field;
					if (offsetX < range.boundingWidth) { 
						break;
					}
				}
			}
		}
		$.data(input, PROP_NAME, inst);
		$.timeEntry._showField(inst);
		$.timeEntry._focussed = false;
	},

	/* Handle keystrokes in the field.
	   @param  event  (event) the keydown event
	   @return  (boolean) true to continue, false to stop processing */
	_doKeyDown: function(event) {
		if (event.keyCode >= 48) { 
			return true;
		}
		var inst = $.data(event.target, PROP_NAME);
		switch (event.keyCode) {
			case 9: return (event.shiftKey ?
						
						$.timeEntry._changeField(inst, -1, true) :
						
						$.timeEntry._changeField(inst, +1, true));
			case 35: if (event.ctrlKey) { 
						$.timeEntry._setValue(inst, '');
					}
					else { 
						inst._field = Math.max(1, inst._secondField, inst._ampmField);
						$.timeEntry._adjustField(inst, 0);
					}
					break;
			case 36: if (event.ctrlKey) { 
						$.timeEntry._setTime(inst);
					}
					else {
						inst._field = 0;
						$.timeEntry._adjustField(inst, 0);
					}
					break;
			case 37: $.timeEntry._changeField(inst, -1, false); break; 
			case 38: $.timeEntry._adjustField(inst, +1); break;
			case 39: $.timeEntry._changeField(inst, +1, false); break; 
			case 40: $.timeEntry._adjustField(inst, -1); break;
			case 46: $.timeEntry._setValue(inst, ''); break;
		}
		return false;
	},

	/* Disallow unwanted characters.
	   @param  event  (event) the keypress event
	   @return  (boolean) true to continue, false to stop processing */
	_doKeyPress: function(event) {
		var chr = String.fromCharCode(event.charCode == undefined ? event.keyCode : event.charCode);
		if (chr < ' ') {
			return true;
		}
		var inst = $.data(event.target, PROP_NAME);
		$.timeEntry._handleKeyPress(inst, chr);
		return false;
	},

	/* Increment/decrement on mouse wheel activity.
	   @param  event  (event) the mouse wheel event
	   @param  delta  (number) the amount of change */
	_doMouseWheel: function(event, delta) {
		if ($.timeEntry._isDisabledTimeEntry(event.target)) {
			return;
		}
		delta = ($.browser.opera ? -delta / Math.abs(delta) :
			($.browser.safari ? delta / Math.abs(delta) : delta));
		var inst = $.data(event.target, PROP_NAME);
		inst.input.focus();
		if (!inst.input.val()) {
			$.timeEntry._parseTime(inst);
		}
		$.timeEntry._adjustField(inst, delta);
		event.preventDefault();
	},

	/* Expand the spinner, if possible, to make it easier to use.
	   @param  event  (event) the mouse over event */
	_expandSpinner: function(event) {
		var spinner = $.timeEntry._getSpinnerTarget(event);
		var inst = $.data($.timeEntry._getInput(spinner), PROP_NAME);
		var spinnerBigImage = $.timeEntry._get(inst, 'spinnerBigImage');
		if (spinnerBigImage) {
			inst._expanded = true;
			var offset = $(spinner).offset();
			var relative = null;
			$(spinner).parents().each(function() {
				var parent = $(this);
				if (parent.css('position') == 'relative' ||
						parent.css('position') == 'absolute') {
					relative = parent.offset();
				}
				return !relative;
			});
			var spinnerSize = $.timeEntry._get(inst, 'spinnerSize');
			var spinnerBigSize = $.timeEntry._get(inst, 'spinnerBigSize');
			$('<div class="timeEntry_expand" style="position: absolute; left: ' +
				(offset.left - (spinnerBigSize[0] - spinnerSize[0]) / 2 -
				(relative ? relative.left : 0)) + 'px; top: ' + (offset.top -
				(spinnerBigSize[1] - spinnerSize[1]) / 2 - (relative ? relative.top : 0)) +
				'px; width: ' + spinnerBigSize[0] + 'px; height: ' +
				spinnerBigSize[1] + 'px; background: transparent url(' +
				spinnerBigImage + ') no-repeat 0px 0px; z-index: 10;"></div>').
				mousedown($.timeEntry._handleSpinner).mouseup($.timeEntry._endSpinner).
				mouseout($.timeEntry._endExpand).mousemove($.timeEntry._describeSpinner).
				insertAfter(spinner);
		}
	},

	/* Locate the actual input field from the spinner.
	   @param  spinner  (element) the current spinner
	   @return  (element) the corresponding input */
	_getInput: function(spinner) {
		return $(spinner).siblings('.' + $.timeEntry.markerClassName)[0];
	},

	/* Change the title based on position within the spinner.
	   @param  event  (event) the mouse move event */
	_describeSpinner: function(event) {
		var spinner = $.timeEntry._getSpinnerTarget(event);
		var inst = $.data($.timeEntry._getInput(spinner), PROP_NAME);
		spinner.title = $.timeEntry._get(inst, 'spinnerTexts')
			[$.timeEntry._getSpinnerRegion(inst, event)];
	},

	/* Handle a click on the spinner.
	   @param  event  (event) the mouse click event */
	_handleSpinner: function(event) {
		var spinner = $.timeEntry._getSpinnerTarget(event);
		var input = $.timeEntry._getInput(spinner);
		if ($.timeEntry._isDisabledTimeEntry(input)) {
			return;
		}
		if (input == $.timeEntry._blurredInput) {
			$.timeEntry._lastInput = input;
			$.timeEntry._blurredInput = null;
		}
		var inst = $.data(input, PROP_NAME);
		$.timeEntry._doFocus(input);
		var region = $.timeEntry._getSpinnerRegion(inst, event);
		$.timeEntry._changeSpinner(inst, spinner, region);
		$.timeEntry._actionSpinner(inst, region);
		$.timeEntry._timer = null;
		$.timeEntry._handlingSpinner = true;
		var spinnerRepeat = $.timeEntry._get(inst, 'spinnerRepeat');
		if (region >= 3 && spinnerRepeat[0]) { 
			$.timeEntry._timer = setTimeout(
				function() { $.timeEntry._repeatSpinner(inst, region); },
				spinnerRepeat[0]);
			$(spinner).one('mouseout', $.timeEntry._releaseSpinner).
				one('mouseup', $.timeEntry._releaseSpinner);
		}
	},

	/* Action a click on the spinner.
	   @param  inst    (object) the instance settings
	   @param  region  (number) the spinner "button" */
	_actionSpinner: function(inst, region) {
		if (!inst.input.val()) {
			$.timeEntry._parseTime(inst);
		}
		switch (region) {
			case 0: this._setTime(inst); break;
			case 1: this._changeField(inst, -1, false); break;
			case 2: this._changeField(inst, +1, false); break;
			case 3: this._adjustField(inst, +1); break;
			case 4: this._adjustField(inst, -1); break;
		}
	},

	/* Repeat a click on the spinner.
	   @param  inst    (object) the instance settings
	   @param  region  (number) the spinner "button" */
	_repeatSpinner: function(inst, region) {
		if (!$.timeEntry._timer) {
			return;
		}
		$.timeEntry._lastInput = $.timeEntry._blurredInput;
		this._actionSpinner(inst, region);
		this._timer = setTimeout(
			function() { $.timeEntry._repeatSpinner(inst, region); },
			this._get(inst, 'spinnerRepeat')[1]);
	},

	/* Stop a spinner repeat.
	   @param  event  (event) the mouse event */
	_releaseSpinner: function(event) {
		clearTimeout($.timeEntry._timer);
		$.timeEntry._timer = null;
	},

	/* Tidy up after an expanded spinner.
	   @param  event  (event) the mouse event */
	_endExpand: function(event) {
		$.timeEntry._timer = null;
		var spinner = $.timeEntry._getSpinnerTarget(event);
		var input = $.timeEntry._getInput(spinner);
		var inst = $.data(input, PROP_NAME);
		$(spinner).remove();
		inst._expanded = false;
	},

	/* Tidy up after a spinner click.
	   @param  event  (event) the mouse event */
	_endSpinner: function(event) {
		$.timeEntry._timer = null;
		var spinner = $.timeEntry._getSpinnerTarget(event);
		var input = $.timeEntry._getInput(spinner);
		var inst = $.data(input, PROP_NAME);
		if (!$.timeEntry._isDisabledTimeEntry(input)) {
			$.timeEntry._changeSpinner(inst, spinner, -1);
		}
		if ($.timeEntry._handlingSpinner) {
			$.timeEntry._lastInput = $.timeEntry._blurredInput;
		}
		if ($.timeEntry._lastInput && $.timeEntry._handlingSpinner) {
			$.timeEntry._showField(inst);
		}
		$.timeEntry._handlingSpinner = false;
	},

	/* Retrieve the spinner from the event.
	   @param  event  (event) the mouse click event
	   @return  (element) the target field */
	_getSpinnerTarget: function(event) {
		return event.target || event.srcElement;
	},

	/* Determine which "button" within the spinner was clicked.
	   @param  inst   (object) the instance settings
	   @param  event  (event) the mouse event
	   @return  (number) the spinner "button" number */
	_getSpinnerRegion: function(inst, event) {
		var spinner = this._getSpinnerTarget(event);
		var pos = ($.browser.opera || $.browser.safari ?
			$.timeEntry._findPos(spinner) : $(spinner).offset());
		var scrolled = ($.browser.safari ? $.timeEntry._findScroll(spinner) :
			[document.documentElement.scrollLeft || document.body.scrollLeft,
			document.documentElement.scrollTop || document.body.scrollTop]);
		var spinnerIncDecOnly = this._get(inst, 'spinnerIncDecOnly');
		var left = (spinnerIncDecOnly ? 99 : event.clientX + scrolled[0] -
			pos.left - ($.browser.msie ? 2 : 0));
		var top = event.clientY + scrolled[1] - pos.top - ($.browser.msie ? 2 : 0);
		var spinnerSize = this._get(inst, (inst._expanded ? 'spinnerBigSize' : 'spinnerSize'));
		var right = (spinnerIncDecOnly ? 99 : spinnerSize[0] - 1 - left);
		var bottom = spinnerSize[1] - 1 - top;
		if (spinnerSize[2] > 0 && Math.abs(left - right) <= spinnerSize[2] &&
				Math.abs(top - bottom) <= spinnerSize[2]) {
			return 0;
		}
		var min = Math.min(left, top, right, bottom);
		return (min == left ? 1 : (min == right ? 2 : (min == top ? 3 : 4))); 
	},

	/* Change the spinner image depending on button clicked.
	   @param  inst     (object) the instance settings
	   @param  spinner  (element) the spinner control
	   @param  region   (number) the spinner "button" */
	_changeSpinner: function(inst, spinner, region) {
		$(spinner).css('background-position', '-' + ((region + 1) *
			this._get(inst, (inst._expanded ? 'spinnerBigSize' : 'spinnerSize'))[0]) + 'px 0px');
	},

	/* Find an object's position on the screen.
	   @param  obj  (element) the control
	   @return  (object) position as .left and .top */
	_findPos: function(obj) {
		var curLeft = curTop = 0;
		if (obj.offsetParent) {
			curLeft = obj.offsetLeft;
			curTop = obj.offsetTop;
			while (obj = obj.offsetParent) {
				var origCurLeft = curLeft;
				curLeft += obj.offsetLeft;
				if (curLeft < 0) {
					curLeft = origCurLeft;
				}
				curTop += obj.offsetTop;
			}
		}
		return {left: curLeft, top: curTop};
	},

	/* Find an object's scroll offset on the screen.
	   @param  obj  (element) the control
	   @return  (number[]) offset as [left, top] */
	_findScroll: function(obj) {
		var isFixed = false;
		$(obj).parents().each(function() {
			isFixed |= $(this).css('position') == 'fixed';
		});
		if (isFixed) {
			return [0, 0];
		}
		var scrollLeft = obj.scrollLeft;
		var scrollTop = obj.scrollTop;
		while (obj = obj.parentNode) {
			scrollLeft += obj.scrollLeft || 0;
			scrollTop += obj.scrollTop || 0;
		}
		return [scrollLeft, scrollTop];
	},

	/* Get a setting value, defaulting if necessary.
	   @param  inst  (object) the instance settings
	   @param  name  (string) the setting name
	   @return  (any) the setting value */
	_get: function(inst, name) {
		return (inst.options[name] != null ?
			inst.options[name] : $.timeEntry._defaults[name]);
	},

	/* Extract the time value from the input field, or default to now.
	   @param  inst  (object) the instance settings */
	_parseTime: function(inst) {
		var currentTime = this._extractTime(inst);
		var showSeconds = this._get(inst, 'showSeconds');
		if (currentTime) {
			inst._selectedHour = currentTime[0];
			inst._selectedMinute = currentTime[1];
			inst._selectedSecond = currentTime[2];
		}
		else {
			var now = this._constrainTime(inst);
			inst._selectedHour = now[0];
			inst._selectedMinute = now[1];
			inst._selectedSecond = (showSeconds ? now[2] : 0);
		}
		inst._secondField = (showSeconds ? 2 : -1);
		inst._ampmField = (this._get(inst, 'show24Hours') ? -1 : (showSeconds ? 3 : 2));
		inst._lastChr = '';
		inst._field = Math.max(0, Math.min(
			Math.max(1, inst._secondField, inst._ampmField), this._get(inst, 'initialField')));
		if (inst.input.val() != '') {
			this._showTime(inst);
		}
	},

	/* Extract the time value from a string as an array of values, or default to null.
	   @param  inst   (object) the instance settings
	   @param  value  (string) the time value to parse
	   @return  (number[3]) the time components (hours, minutes, seconds)
	            or null if no value */
	_extractTime: function(inst, value) {
		value = value || inst.input.val();
		var separator = this._get(inst, 'separator');
		var currentTime = value.split(separator);
		if (separator == '' && value != '') {
			currentTime[0] = value.substring(0, 2);
			currentTime[1] = value.substring(2, 4);
			currentTime[2] = value.substring(4, 6);
		}
		var ampmNames = this._get(inst, 'ampmNames');
		var show24Hours = this._get(inst, 'show24Hours');
		if (currentTime.length >= 2) {
			var isAM = !show24Hours && (value.indexOf(ampmNames[0]) > -1);
			var isPM = !show24Hours && (value.indexOf(ampmNames[1]) > -1);
			var hour = parseInt(currentTime[0], 10);
			hour = (isNaN(hour) ? 0 : hour);
			hour = ((isAM || isPM) && hour == 12 ? 0 : hour) + (isPM ? 12 : 0);
			var minute = parseInt(currentTime[1], 10);
			minute = (isNaN(minute) ? 0 : minute);
			var second = (currentTime.length >= 3 ?
				parseInt(currentTime[2], 10) : 0);
			second = (isNaN(second) || !this._get(inst, 'showSeconds') ? 0 : second);
			return this._constrainTime(inst, [hour, minute, second]);
		} 
		return null;
	},

	/* Constrain the given/current time to the time steps.
	   @param  inst    (object) the instance settings
	   @param  fields  (number[3]) the current time components (hours, minutes, seconds)
	   @return  (number[3]) the constrained time components (hours, minutes, seconds) */
	_constrainTime: function(inst, fields) {
		var specified = (fields != null);
		if (!specified) {
			var now = this._determineTime(inst, this._get(inst, 'defaultTime')) || new Date();
			fields = [now.getHours(), now.getMinutes(), now.getSeconds()];
		}
		var reset = false;
		var timeSteps = this._get(inst, 'timeSteps');
		for (var i = 0; i < timeSteps.length; i++) {
			if (reset) {
				fields[i] = 0;
			}
			else if (timeSteps[i] > 1) {
				fields[i] = Math.round(fields[i] / timeSteps[i]) * timeSteps[i];
				reset = true;
			}
		}
		return fields;
	},

	/* Set the selected time into the input field.
	   @param  inst  (object) the instance settings */
	_showTime: function(inst) {
		var show24Hours = this._get(inst, 'show24Hours');
		var separator = this._get(inst, 'separator');
		var currentTime = (this._formatNumber(show24Hours ? inst._selectedHour :
			((inst._selectedHour + 11) % 12) + 1) + separator +
			this._formatNumber(inst._selectedMinute) +
			(this._get(inst, 'showSeconds') ? separator +
			this._formatNumber(inst._selectedSecond) : '') +
			(show24Hours ?  '' : this._get(inst, 'ampmPrefix') +
			this._get(inst, 'ampmNames')[(inst._selectedHour < 12 ? 0 : 1)]));
		this._setValue(inst, currentTime);
		this._showField(inst);
	},

	/* Highlight the current time field.
	   @param  inst  (object) the instance settings */
	_showField: function(inst) {
		var input = inst.input[0];
		if (inst.input.is(':hidden') || $.timeEntry._lastInput != input) {
			return;
		}
		var separator = this._get(inst, 'separator');
		var fieldSize = separator.length + 2;
		var start = (inst._field != inst._ampmField ? (inst._field * fieldSize) :
			(inst._ampmField * fieldSize) - separator.length + this._get(inst, 'ampmPrefix').length);
		var end = start + (inst._field != inst._ampmField ? 2 : this._get(inst, 'ampmNames')[0].length);
		if (input.setSelectionRange) { 
			input.setSelectionRange(start, end);
		}
		else if (input.createTextRange) { 
			var range = input.createTextRange();
			range.moveStart('character', start);
			range.moveEnd('character', end - inst.input.val().length);
			range.select();
		}
		if (!input.disabled) {
			input.focus();
		}
	},

	/* Ensure displayed single number has a leading zero.
	   @param  value  (number) current value
	   @return  (string) number with at least two digits */
	_formatNumber: function(value) {
		return (value < 10 ? '0' : '') + value;
	},

	/* Update the input field and notify listeners.
	   @param  inst   (object) the instance settings
	   @param  value  (string) the new value */
	_setValue: function(inst, value) {
		if (value != inst.input.val()) {
			inst.input.val(value).trigger('change');
		}
	},

	/* Move to previous/next field, or out of field altogether if appropriate.
	   @param  inst     (object) the instance settings
	   @param  offset   (number) the direction of change (-1, +1)
	   @param  moveOut  (boolean) true if can move out of the field
	   @return  (boolean) true if exitting the field, false if not */
	_changeField: function(inst, offset, moveOut) {
		var atFirstLast = (inst.input.val() == '' || inst._field ==
			(offset == -1 ? 0 : Math.max(1, inst._secondField, inst._ampmField)));
		if (!atFirstLast) {
			inst._field += offset;
		}
		this._showField(inst);
		inst._lastChr = '';
		$.data(inst.input[0], PROP_NAME, inst);
		return (atFirstLast && moveOut);
	},

	/* Update the current field in the direction indicated.
	   @param  inst    (object) the instance settings
	   @param  offset  (number) the amount to change by */
	_adjustField: function(inst, offset) {
		if (inst.input.val() == '') {
			offset = 0;
		}
		var timeSteps = this._get(inst, 'timeSteps');
		this._setTime(inst, new Date(0, 0, 0,
			inst._selectedHour + (inst._field == 0 ? offset * timeSteps[0] : 0) +
			(inst._field == inst._ampmField ? offset * 12 : 0),
			inst._selectedMinute + (inst._field == 1 ? offset * timeSteps[1] : 0),
			inst._selectedSecond + (inst._field == inst._secondField ? offset * timeSteps[2] : 0)));
	},

	/* Check against minimum/maximum and display time.
	   @param  inst  (object) the instance settings
	   @param  time  (Date) an actual time or
	                 (number) offset in seconds from now or
					 (string) units and periods of offsets from now */
	_setTime: function(inst, time) {
		time = this._determineTime(inst, time);
		var fields = this._constrainTime(inst, time ?
			[time.getHours(), time.getMinutes(), time.getSeconds()] : null);
		time = new Date(0, 0, 0, fields[0], fields[1], fields[2]);
		
		var time = this._normaliseTime(time);
		var minTime = this._normaliseTime(this._determineTime(inst, this._get(inst, 'minTime')));
		var maxTime = this._normaliseTime(this._determineTime(inst, this._get(inst, 'maxTime')));
		
		time = (minTime && time < minTime ? minTime :
			(maxTime && time > maxTime ? maxTime : time));
		var beforeSetTime = this._get(inst, 'beforeSetTime');
		
		if (beforeSetTime) {
			time = beforeSetTime.apply(inst.input[0],
				[this._getTimeTimeEntry(inst.input[0]), time, minTime, maxTime]);
		}
		inst._selectedHour = time.getHours();
		inst._selectedMinute = time.getMinutes();
		inst._selectedSecond = time.getSeconds();
		this._showTime(inst);
		$.data(inst.input[0], PROP_NAME, inst);
	},

	/* Normalise time object to a common date.
	   @param  time  (Date) the original time
	   @return  (Date) the normalised time */
	_normaliseTime: function(time) {
		if (!time) {
			return null;
		}
		time.setFullYear(1900);
		time.setMonth(0);
		time.setDate(0);
		return time;
	},

	/* A time may be specified as an exact value or a relative one.
	   @param  inst     (object) the instance settings
	   @param  setting  (Date) an actual time or
	                    (number) offset in seconds from now or
	                    (string) units and periods of offsets from now
	   @return  (Date) the calculated time */
	_determineTime: function(inst, setting) {
		var offsetNumeric = function(offset) { 
			var time = new Date();
			time.setTime(time.getTime() + offset * 1000);
			return time;
		};
		var offsetString = function(offset) { 
			var fields = $.timeEntry._extractTime(inst, offset); 
			var time = new Date();
			var hour = (fields ? fields[0] : time.getHours());
			var minute = (fields ? fields[1] : time.getMinutes());
			var second = (fields ? fields[2] : time.getSeconds());
			if (!fields) {
				var pattern = /([+-]?[0-9]+)\s*(s|S|m|M|h|H)?/g;
				var matches = pattern.exec(offset);
				while (matches) {
					switch (matches[2] || 's') {
						case 's' : case 'S' :
							second += parseInt(matches[1], 10); break;
						case 'm' : case 'M' :
							minute += parseInt(matches[1], 10); break;
						case 'h' : case 'H' :
							hour += parseInt(matches[1], 10); break;
					}
					matches = pattern.exec(offset);
				}
			}
			time = new Date(0, 0, 10, hour, minute, second, 0);
			if (/^!/.test(offset)) {
				if (time.getDate() > 10) {
					time = new Date(0, 0, 10, 23, 59, 59);
				}
				else if (time.getDate() < 10) {
					time = new Date(0, 0, 10, 0, 0, 0);
				}
			}
			return time;
		};
		return (setting ? (typeof setting == 'string' ? offsetString(setting) :
			(typeof setting == 'number' ? offsetNumeric(setting) : setting)) : null);
	},

	/* Update time based on keystroke entered.
	   @param  inst  (object) the instance settings
	   @param  chr   (ch) the new character */
	_handleKeyPress: function(inst, chr) {
		if (chr == this._get(inst, 'separator')) {
			this._changeField(inst, +1, false);
		}
		else if (chr >= '0' && chr <= '9') { 
			var key = parseInt(chr, 10);
			var value = parseInt(inst._lastChr + chr, 10);
			var show24Hours = this._get(inst, 'show24Hours');
			var hour = (inst._field != 0 ? inst._selectedHour :
				(show24Hours ? (value < 24 ? value : key) :
				(value >= 1 && value <= 12 ? value :
				(key > 0 ? key : inst._selectedHour)) % 12 +
				(inst._selectedHour >= 12 ? 12 : 0)));
			var minute = (inst._field != 1 ? inst._selectedMinute :
				(value < 60 ? value : key));
			var second = (inst._field != inst._secondField ? inst._selectedSecond :
				(value < 60 ? value : key));
			var fields = this._constrainTime(inst, [hour, minute, second]);
			this._setTime(inst, new Date(0, 0, 0, fields[0], fields[1], fields[2]));
			inst._lastChr = chr;
		}
		else if (!this._get(inst, 'show24Hours')) { 
			chr = chr.toLowerCase();
			var ampmNames = this._get(inst, 'ampmNames');
			if ((chr == ampmNames[0].substring(0, 1).toLowerCase() &&
					inst._selectedHour >= 12) ||
					(chr == ampmNames[1].substring(0, 1).toLowerCase() &&
					inst._selectedHour < 12)) {
				var saveField = inst._field;
				inst._field = inst._ampmField;
				this._adjustField(inst, +1);
				inst._field = saveField;
				this._showField(inst);
			}
		}
	}
});

/* jQuery extend now ignores nulls!
   @param  target  (object) the object to update
   @param  props   (object) the new settings 
   @return  (object) the updated object */
function extendRemove(target, props) {
	$.extend(target, props);
	for (var name in props) {
		if (props[name] == null) {
			target[name] = null;
		}
	}
	return target;
}


var getters = ['getOffset', 'getTime', 'isDisabled'];

/* Attach the time entry functionality to a jQuery selection.
   @param  command  (string) the command to run (optional, default 'attach')
   @param  options  (object) the new settings to use for these countdown instances (optional)
   @return  (jQuery) for chaining further calls */
$.fn.timeEntry = function(options) {
	var otherArgs = Array.prototype.slice.call(arguments, 1);
	if (typeof options == 'string' && $.inArray(options, getters) > -1) {
		return $.timeEntry['_' + options + 'TimeEntry'].apply($.timeEntry, [this[0]].concat(otherArgs));
	}
	return this.each(function() {
		var nodeName = this.nodeName.toLowerCase();
		if (nodeName == 'input') {
			if (typeof options == 'string') {
				$.timeEntry['_' + options + 'TimeEntry'].apply($.timeEntry, [this].concat(otherArgs));
			}
			else {
				
				var inlineSettings = ($.fn.metadata ? $(this).metadata() : {});
				$.timeEntry._connectTimeEntry(this, $.extend(inlineSettings, options));
			}
		} 
	});
};


$.timeEntry = new TimeEntry(); 

})(jQuery);
