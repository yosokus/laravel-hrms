
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
