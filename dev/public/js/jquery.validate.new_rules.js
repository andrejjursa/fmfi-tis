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