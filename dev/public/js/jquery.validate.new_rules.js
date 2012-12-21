jQuery.validator.addMethod('greater_than', function(value, element, param) {
    var compare_to = 0;
    try {
        compare_to = jQuery(param).val();
        param = compare_to;
    } catch (e) {
        compare_to = param;
    }
    console.log(value + ' > ' + compare_to);
    return this.optional(element) || value - compare_to > 0;
}, jQuery.validator.format('Value must be greater than {0}.'));

jQuery.validator.addMethod('lesser_than', function(value, element, param) {
    var compare_to = 0;
    try {
        compare_to = jQuery(param).val();
        param = compare_to;
    } catch (e) {
        compare_to = param;
    }
    return this.optional(element) || value - compare_to < 0;
}, jQuery.validator.format('Value must be lesser than {0}.'));

jQuery.validator.addMethod('lesserequal_than', function(value, element, param) {
    var compare_to = 0;
    try {
        compare_to = jQuery(param).val();
        param = compare_to;
    } catch (e) {
        compare_to = param;
    }
    return this.optional(element) || value - compare_to <= 0;
}, jQuery.validator.format('Value must be lesser or equal than {0}.'));

jQuery.validator.addMethod('greaterequal_than', function(value, element, param) {
    var compare_to = 0;
    try {
        compare_to = jQuery(param).val();
        param = compare_to;
    } catch (e) {
        compare_to = param;
    }
    return this.optional(element) || value - compare_to >= 0;
}, jQuery.validator.format('Value must be greater or equal than {0}.'));

jQuery.validator.addMethod('min_mm_items', function(value, element, param) {
    if (value == '' || value == '0') {
        return 0 >= param;
    }
    var valarray = value.split(',');
    return valarray.length >= param;
}, jQuery.validator.format('You must select at least {0} items.'));

jQuery.validator.addMethod('max_mm_items', function(value, element, param) {
    if (value == '' || value == '0') {
        return 0 <= param;
    }
    var valarray = value.split(',');
    return valarray.length <= param;
}, jQuery.validator.format('You must select maximum of {0} items.'));

jQuery.validator.addMethod('required_html', function(value, element, param) {
    var plain_text = value.replace(/(<([^>]+)>)/ig,'').replace(/\&nbsp;/ig, '');
    var trimed_plain_text = jQuery.trim(plain_text);
    return trimed_plain_text != '';
}, 'This field is required.');

jQuery.validator.addMethod('remote_check', function(value, element, param) {
    var data = jQuery(element).parents('form').serializeArray();
    var previous = this.previousValue(element);
    if ( this.pending[element.name] ) {
		return "pending";
	}
	if ( previous.old === value ) {
		return previous.valid;
	}
    previous.old = value;
    var validator = this;
    validator.startRequest(element);
    jQuery.ajax(param, {
        cache: false,
        dataType: 'json',
        type: 'post',
        mode: "abort",
        port: "validate" + element.name,
        data: data,
        async: true,
        success: function(result) {
            var valid = result === true || result === "true";
			if ( valid ) {
				var submitted = validator.formSubmitted;
				validator.prepareElement(element);
				validator.formSubmitted = submitted;
				validator.successList.push(element);
				delete validator.invalid[element.name];
				validator.showErrors();
			} else {
				var errors = {};
                var message = validator.defaultMessage( element, "remote_check" );
                errors[element.name] = message;
				validator.invalid[element.name] = true;
				validator.showErrors(errors);
			}
            previous.valid = valid;
            validator.stopRequest(element, valid);
        },
        error: function() {
            return false;
        }
    });
    return 'pending';
}, 'This field does not pass remote validation check.');

jQuery.validator.addMethod('required_if_new', function(value, element, param) {
    var row_id = jQuery(element).parents('form').find('input[name=row_id]');
    if (row_id.length == 0) {
        // check if dependency is met
		if ( !this.depend(param, element) ) {
			return "dependency-mismatch";
		}
		if ( element.nodeName.toLowerCase() === "select" ) {
			// could be an array for select-multiple or a string, both are fine this way
			var val = $(element).val();
			return val && val.length > 0;
		}
		if ( this.checkable(element) ) {
			return this.getLength(value, element) > 0;
		}
		return $.trim(value).length > 0;
    }
    return true;
}, 'This field is required.');