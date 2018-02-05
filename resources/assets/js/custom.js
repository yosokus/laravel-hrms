
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

var defaultDataTableOptions = {
    ajax: {},
    processing: true,
    deferRender: true,
    serverSide: false,
    paging: false,
    info: false,
    lengthChange: false,
    pageLength: 25,
    lengthMenu: [
        [10, 25, 50, 100, 250, 500, 1000, -1],
        [10, 25, 50, 100, 250, 500, 1000, 'All']
    ],
    'order': [[ 2, 'desc' ]],
    dom: '<"table-header pull-right"fr><"table-container"t><"table-footer row"<"col-md-3 info-container"i><"col-md-3 page-length-selector"l><"col-md-6 pages"p>>'
};

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
