
$(document).on('click', '.delete-confirmation', function() {
    if (!confirm('Are you sure you want to delete this item')) {
        return false;
    }
});

$(document).on('click', '.delete-all-confirmation', function() {
    if (!confirm('Are you sure you want to delete this item and all its sub-items')) {
        return false;
    }
});

var datepicker = $.fn.datepicker.noConflict();
$.fn.bootstrapDP = datepicker;
$(".date-picker").bootstrapDP({
    todayHighlight: true,
    clearBtn: true,
    autoclose: true
});

function formatDate(value, format, displayFormat) {
    if (! isUndefined(value) || value == '') {
        return '';
    }
    if (typeof moment == 'function') {
        if (! isUndefined(format)) {
            format = 'YYYY-MM-DD H:mm:ss';
        }
        if (! isUndefined(displayFormat)) {
            displayFormat = 'DD.MM.YYYY';
        }
        var displayDate = moment(value, format).format(displayFormat);
        value = isUndefined(displayDate) ?  displayDate : value;
    }
    return value;
}
