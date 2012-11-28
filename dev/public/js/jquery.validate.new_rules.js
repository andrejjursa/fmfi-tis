jQuery.validator.addMethod('greater_than', function(value, element, param) {
    var compare_to = 0;
    try {
        compare_to = jQuery(param).val();
        param = compare_to;
    } catch (e) {
        compare_to = param;
    }
    return this.optional(element) || value > compare_to;
}, jQuery.validator.format('Value must be greater than {0}.'));

jQuery.validator.addMethod('lesser_than', function(value, element, param) {
    var compare_to = 0;
    try {
        compare_to = jQuery(param).val();
        param = compare_to;
    } catch (e) {
        compare_to = param;
    }
    return this.optional(element) || value < compare_to;
}, jQuery.validator.format('Value must be lesser than {0}.'));

jQuery.validator.addMethod('lesserequal_than', function(value, element, param) {
    var compare_to = 0;
    try {
        compare_to = jQuery(param).val();
        param = compare_to;
    } catch (e) {
        compare_to = param;
    }
    return this.optional(element) || value <= compare_to;
}, jQuery.validator.format('Value must be lesser or equal than {0}.'));

jQuery.validator.addMethod('greaterequal_than', function(value, element, param) {
    var compare_to = 0;
    try {
        compare_to = jQuery(param).val();
        param = compare_to;
    } catch (e) {
        compare_to = param;
    }
    return this.optional(element) || value >= compare_to;
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