// Delete record
$(document).on('click', '.delete', function() {
    var slug = $(this).attr('data-slug');
    var delete_url = $(this).attr('data-del-url');
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: delete_url,
                type: 'DELETE',
                success: function(response) {
                    if (response) {
                        toastr.success(response.message);
                        var oTable = $('.data_table').dataTable();
                        oTable.fnDraw(false);
                    } else {
                        toastr.error('Sorry something went wrong.');
                    }
                }
            });
        }
    })
});

// Restore record
$(document).on('click', '.restore', function() {
    var slug = $(this).attr('data-slug');
    var restore_url = $(this).attr('data-res-url');
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, restore it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: restore_url,
                type: 'GET',
                success: function(response) {
                    if (response) {
                        toastr.success(response.message);
                        var oTable = $('.data_table').dataTable();
                        oTable.fnDraw(false);
                    } else {
                        toastr.error('Sorry something went wrong.');
                    }
                }
            });
        }
    })
});

// Submit fileUpload
$(document).ready(function() {
    $("form.submitBtnWithFileUpload").on('submit', function(e) {
        e.preventDefault();
        var thi = $(this);
        var actionName = $(this).attr('action');
        var dataMethod = $(this).attr('data-method');
        var modal_id = $(this).attr('data-modal-id');
        // Get the form data
        var formElement = $('#' + modal_id).find('#create-form');

        var formData = new FormData(formElement[0]);

        // ✅ Always force CKEditor content into formData
        if (CKEDITOR.instances.description) {
            var editorData = CKEDITOR.instances.description.getData();
            formData.set('description', editorData);
            // `set` ensures it overrides existing textarea value (even if empty)
        }

        thi.find('.sub-btn').hide();
        thi.find('.loading-btn').show();

        $.ajax({
            type: 'post',
            url: actionName,
            data: formData,
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },

            success: function(response) {
                thi.find('.sub-btn').show();
                thi.find('.loading-btn').hide();
                if (response.success) {
                    toastr.success(response.message);
                    var oTable = $('.data_table').dataTable();
                    oTable.fnDraw(false);
                    $('#' + modal_id).modal('hide');
                    Swal.fire(
                        'Done!',
                        response.message,
                        'success'
                    )
                } else if (response.error) {
                    toastr.error(response.error);
                } else if (response.error == false) {
                    toastr.error(response.message);
                }
            },
            error: function(xhr) {
                thi.find('.sub-btn').show();
                thi.find('.loading-btn').hide();
                // Parse the JSON response to get the error messages
                var errors = JSON.parse(xhr.responseText);
                // Reset the form errors
                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').empty();
                $('.error').empty();

                // Loop through the errors and display them
                $.each(errors.errors, function(key, value) {
                    $('#' + key).addClass('is-invalid'); // Add the is-invalid class to the input element
                    $('#' + key + '_error').text(value[0]); // Add the error message to the error element
                });
            }
        });
    });
});

// Submit
$(document).ready(function() {
    $('.submitBtn').click(function(e) {
        e.preventDefault(); // Prevent the form from submitting normally
        var thi = $(this);
        var url = $(this).closest('form').attr('action');
        var method = $(this).closest('form').attr('data-method');

        var formId = $(this).closest('form').attr('id');
        var modal_id = $(this).closest('form').attr('data-modal-id');

        // Get the form data
        var formData = $('#' + modal_id).find('#' + formId).serialize();

        // Check if the description variable exists in the serialized form data
        var fieldExists = formData.indexOf('description=') > -1;

        if (fieldExists) {
            var editorData = CKEDITOR.instances.description.getData();
            // Combine the editor data with the serialized form data
            formData = formData + '&description=' + encodeURIComponent(editorData);
        }

        thi.parents('.action-btn').find('.sub-btn').hide();
        thi.parents('.action-btn').find('.loading-btn').show();

        // Send the AJAX request
        $.ajax({
            url: url,
            method: method,
            data: formData,
            success: function(response) {
                thi.parents('.action-btn').find('.sub-btn').show();
                thi.parents('.action-btn').find('.loading-btn').hide();
                if (response.success) {
                    if (response.message && response.message != "") {
                        toastr.success(response.message, { timeOut: 1000 });
                    }
                    var oTable = $('.data_table').dataTable(); oTable.fnDraw(false);
                    $('#' + modal_id).modal('hide'); $('#' + modal_id).removeClass('show'); $('#' + modal_id).parents('.card').find('.offcanvas-backdrop').removeClass('show');
                }else if (response.error) {
                    toastr.error(response.error);
                }
            },
            error: function(xhr) {
                thi.parents('.action-btn').find('.sub-btn').show();
                thi.parents('.action-btn').find('.loading-btn').hide();
                // Parse the JSON response to get the error messages
                var errors = JSON.parse(xhr.responseText);

                // Reset the form errors
                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').empty();
                $('.error').empty();

                // Loop through the errors and display them
                $.each(errors.errors, function(key, value) {
                    $('#' + modal_id).find('#' + formId).find('#' + key ).addClass('is-invalid');
                    $('#' + modal_id).find('#' + formId).find('#' + key + '_error').text(value[0]);
                });
            }
        });
    });
    // Submit Btn

    //change password
    $('.generatePasswordBtn').click(function(e) {
        e.preventDefault(); // Prevent the form from submitting normally
        var thi = $(this);

        var url = $(this).closest('form').attr('action');
        var method = $(this).closest('form').attr('data-method');
        var formId = $(this).closest('form').attr('id');
        var modal_id = $(this).closest('form').attr('data-modal-id');

        // Get the form data
        var formData = $('#' + modal_id).find('#' + formId).serialize();
        var clickedButtonValue = $('#' + modal_id).find('.generatePasswordBtn:focus').val(); // Get the value of the clicked button

        // Append the clicked button's value to the serialized form data
        formData += '&clicked_button=' + encodeURIComponent(clickedButtonValue);

        thi.parents('.action-btn').find('.sub-btn').hide();
        thi.parents('.action-btn').find('.loading-btn').show();

        // Send the AJAX request
        $.ajax({
            url: url,
            method: method,
            data: formData,
            success: function(response) {
                if (response.success == true) {
                    thi.parents('.action-btn').find('.sub-btn').show();
                    thi.parents('.action-btn').find('.loading-btn').hide();
                    $('#input-password').val(response);
                } else {
                    thi.parents('.action-btn').find('.sub-btn').show();
                    thi.parents('.action-btn').find('.loading-btn').hide();
                    $('#input-password').val(response);
                }
            },
            error: function(xhr) {
                thi.parents('.action-btn').find('.sub-btn').show();
                thi.parents('.action-btn').find('.loading-btn').hide();
                // Parse the JSON response to get the error messages
                var errors = JSON.parse(xhr.responseText);
                // Reset the form errors
                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').empty();
                $('.error').empty();

                // Loop through the errors and display them
                $.each(errors.errors, function(key, value) {
                    $('#' + key).addClass('is-invalid'); // Add the is-invalid class to the input element
                    $('#' + key + '_error').text(value[0]); // Add the error message to the error element
                });
            }
        });
    });
    //change password
});

// Add action
$(document).on('click', '#add-btn, .add-btn', function() {
    var targeted_modal = $(this).attr('data-bs-target');
    var data = $(this).attr('data-ids');
    // Clear all form inputs, textareas, and selects
    $(targeted_modal).find('form')[0].reset();
    $(targeted_modal).find('.is-invalid').removeClass('is-invalid');
    $(targeted_modal).find('.invalid-feedback').empty();
    $(targeted_modal).find('.error').empty();

    // Manually clear inputs, textareas, selects, checkboxes, and radios
    $(targeted_modal).find('input[type="text"], input[type="number"], input[type="date"], input[type="email"], input[type="time"], textarea').val('');
    $(targeted_modal).find('select').val(null).trigger('change');
    $(targeted_modal).find('input[type="checkbox"], input[type="radio"]').prop('checked', false);
    $(targeted_modal).find('#attachment-file').html('');

    // Clear CKEditor content if present
    if (typeof CKEDITOR !== 'undefined') {
        for (var instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].setData('');
        }
    }

    // Set form action and method
    var url = $(this).attr('data-url');
    var modal_label = $(this).attr('title');
    $(targeted_modal).find('#modal-label').html(modal_label);
    $(targeted_modal).find("#create-form").attr("action", url);
    $(targeted_modal).find("#create-form").attr("data-method", 'POST');
    var create_url = $(this).attr('data-create-url');
    // Re-initialize select2 for select elements
    $(targeted_modal).find('select').each(function() {
        if ($(this).data('select2')) {
            $(this).select2('destroy');
        }
        $(this).select2({
            dropdownParent: $(this).parent(),
        });
    });

    $.ajax({
        url: create_url,
        method: 'GET',
        data: {data:data},
        beforeSend: function() {
            $(targeted_modal).find('#edit-content').empty()
        },
        success: function(response) {
            $(targeted_modal).find('#edit-content').html(response);
        }
    });
});

// Open modal for editing
$(document).on('click', '.edit-btn', function() {
    var targeted_modal = $(this).attr('data-bs-target');

    var url = $(this).attr('data-url');
    var modal_label = $(this).attr('title');

    $(targeted_modal).find('#modal-label').html(modal_label);
    $(targeted_modal).find("#create-form").attr("action", url);
    $(targeted_modal).find("#create-form").attr("data-method", 'PUT');

    var edit_url = $(this).attr('data-edit-url');

    $.ajax({
        url: edit_url,
        method: 'GET',
        beforeSend: function() {
            $(targeted_modal).find('#edit-content').empty()
        },
        success: function(response) {
            $(targeted_modal).find('#edit-content').html(response);
        }
    });
});

// Open modal for show Detail
$(document).on('click', '.show', function() {
    var targeted_modal = $(this).attr('data-bs-target');
    var modal_label = $(this).attr('title');

    $(targeted_modal).find('#modal-label').html(modal_label);
    var html = '<div class="d-block w-100">' +
        '<div class="d-block w-100">' +
        '<div class="d-flex justify-content-center align-items-center" style="height: 20vw;>' +
        '<div class="demo-inline-spacing">' +
        '<div class="spinner-border spinner-border-lg text-primary" role="status">' +
        '<span class="visually-hidden">Loading...</span>' +
        '</div>' +
        '</div>' +
        '</div>' +
        '</div>' +
        '</div>';
    $(targeted_modal).find('#show-content').html(html);
    var show_url = $(this).attr('data-show-url');
    $.ajax({
        url: show_url,
        method: 'GET',
        success: function(response) {
            $(targeted_modal).find('#show-content').html(response);
        }
    });
});

// Change password
$(document).on('click', '.change-password-btn', function() {
    $('#input-password').val('');
    $('#copyButton').html('Copy');
    var user_id = $(this).attr('data-user-id');
    $("#change-password-form input[id='input_user_id']").val(user_id);
    $('#change-password-modal').modal('show');
});

// Open modal for editing
$(document).on('click', '.ticket-status', function() {
    var targeted_modal = $(this).attr('data-bs-target');

    var url = $(this).attr('data-url');
    var modal_label = $(this).attr('title');

    $(targeted_modal).find('#modal-label').html(modal_label);
    $(targeted_modal).find("#create-form").attr("action", url);
    $(targeted_modal).find("#create-form").attr("data-method", 'PUT');

    var edit_url = $(this).attr('data-edit-url');
    var type = $(this).attr('data-type');

    $.ajax({
        url: edit_url,
        method: 'GET',
        data : {data:type},
        beforeSend: function() {
            $(targeted_modal).find('#edit-content').empty()
        },
        success: function(response) {
            $(targeted_modal).find('#edit-content').html(response);
        }
    });
});

// Status change
$(document).on('click', '.status-btn', function() {
    var status_url = $(this).attr('data-status-url');
    var status_type = $(this).attr('data-status-type');
    $title = "Do you want to change change status?";
    Swal.fire({
        title: 'Are you sure?',
        text: $title,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, change it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            console.log(status_url);
            $.ajax({
                url: status_url,
                type: 'GET',
                data: { status_type: status_type },
                success: function(response) {
                    if (response.status) {
                        var oTable = $('.data_table').dataTable();
                        oTable.fnDraw(false);
                        toastr.success(response.message);
                    } else {
                        toastr.error(response.message);
                    }
                }
            });
        }
    });
});
