<script>
    $(function () {

    // ==========================================================
    // CSRF Token
    // ==========================================================

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // ==========================================================
    // Select2
    // ==========================================================

    $('.select2').select2({
        width: '100%'
    });

    // ==========================================================
    // DataTable
    // ==========================================================

    let table = $('#blogsDatatable').DataTable({
        processing: true,
        serverSide: true,
        responsive: false,
        autoWidth: false,
        ordering: true,
        searching: true,
        lengthChange: true,
        pageLength: 10,
        lengthMenu: [
            [10,25,50,100],
            [10,25,50,100]
        ],

        ajax: {

            url: "{{ route('blogs.index') }}",

            type: "GET",

            data: function (d) {

                d.search = $('#search').val();

                d.category = $('#category_filter').val();

                d.status = $('#status_filter').val();

                d.featured = $('#featured_filter').val();

                d.date_from = $('#date_from').val();

                d.date_to = $('#date_to').val();

            }

        },

        columns: [
            {
                data: 'checkbox',
                name: 'checkbox',
                orderable: false,
                searchable: false
            },
            {
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                searchable: false,
                orderable: false
            },
            {
                data: 'image',
                name: 'featured_image',
                orderable: false,
                searchable: false
            },
            {
                data: 'title',
                name: 'title'
            },
            {
                data: 'category',
                name: 'category.name'
            },
            {
                data: 'author',
                name: 'author'
            },
            {
                data: 'views',
                name: 'views'
            },
            {
                data: 'featured',
                name: 'featured',
                orderable: false,
                searchable: false
            },
            {
                data: 'status',
                name: 'status',
                orderable: false,
                searchable: false
            },
            {
                data: 'published_at',
                name: 'published_at'
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            }
        ],

        order: [
            [9, 'desc']
        ],

        drawCallback: function () {
            $('#checkAll').prop('checked', false);
            $('#bulkDelete').addClass('d-none');
        }
    });

    // ==========================================================
    // Apply Filters
    // ==========================================================

    $('#filterBtn').on('click', function () {

        table.ajax.reload();

    });

    // ==========================================================
    // Search
    // ==========================================================

    $('#search').on('keyup', function (e) {

        if (e.keyCode == 13) {

            table.ajax.reload();

        }

    });

    // ==========================================================
    // Select Filters
    // ==========================================================

    $('#category_filter, #status_filter, #featured_filter')
        .on('change', function () {

            table.ajax.reload();

        });

    // ==========================================================
    // Date Filters
    // ==========================================================

    $('#date_from, #date_to').on('change', function () {

        table.ajax.reload();

    });

    // ==========================================================
    // Check All
    // ==========================================================

    $(document).on('change', '#checkAll', function () {

        $('.record-checkbox').prop('checked', this.checked).trigger('change');

    });

    // ==========================================================
    // Single Checkbox
    // ==========================================================

    $(document).on('change', '.record-checkbox', function () {

        let total = $('.record-checkbox').length;

        let checked = $('.record-checkbox:checked').length;

        $('#checkAll').prop('checked', total === checked);

        if (checked > 0) {

            $('#bulkDelete').removeClass('d-none');

        } else {

            $('#bulkDelete').addClass('d-none');

        }

    });

    // ==========================================================
    // Reset Filters
    // ==========================================================

    $('#resetFilters, #resetFiltersBottom').on('click', function () {

        $('#search').val('');

        $('#category_filter').val('').trigger('change');

        $('#status_filter').val('').trigger('change');

        $('#featured_filter').val('').trigger('change');

        $('#date_from').val('');

        $('#date_to').val('');

        table.ajax.reload();

    });

    // ==========================================================
    // Change Status
    // ==========================================================

    $(document).on('change', '.changeStatus', function () {

        let status = $(this).is(':checked') ? 1 : 0;

        $.ajax({

            url: "{{ route('blogs.change-status') }}",

            type: "POST",

            data: {

                id: $(this).data('id'),

                status: status

            },

            success: function (response) {

                toastr.success(response.message);

            },

            error: function (xhr) {

                toastr.error(xhr.responseJSON.message ?? 'Something went wrong.');

                table.ajax.reload(null, false);

            }

        });

    });

    // ==========================================================
    // Change Featured
    // ==========================================================

    $(document).on('change', '.changeFeatured', function () {

        let featured = $(this).is(':checked') ? 1 : 0;

        $.ajax({

            url: "{{ route('blogs.change-featured') }}",

            type: "POST",

            data: {

                id: $(this).data('id'),

                featured: featured

            },

            success: function (response) {

                toastr.success(response.message);

            },

            error: function (xhr) {

                toastr.error(xhr.responseJSON.message ?? 'Something went wrong.');

                table.ajax.reload(null, false);

            }

        });

    });

    // ==========================================================
    // Delete Record
    // ==========================================================

    $(document).on('click', '.deleteRecord', function () {

        let url = $(this).data('url');

        Swal.fire({

            title: 'Delete Blog?',

            text: "This action cannot be undone.",

            icon: 'warning',

            showCancelButton: true,

            confirmButtonText: 'Yes, Delete',

            cancelButtonText: 'Cancel',

            customClass: {

                confirmButton: 'btn btn-danger me-2',

                cancelButton: 'btn btn-label-secondary'

            },

            buttonsStyling: false

        }).then((result) => {

            if (result.isConfirmed) {

                $.ajax({

                    url: url,

                    type: "POST",

                    data: {

                        _method: "DELETE"

                    },

                    success: function (response) {

                        toastr.success(response.message);

                        table.ajax.reload(null, false);

                    },

                    error: function (xhr) {

                        toastr.error(xhr.responseJSON.message ?? 'Unable to delete.');

                    }

                });

            }

        });

    });

    // ==========================================================
    // Bulk Delete
    // ==========================================================

    $('#bulkDelete').on('click', function () {

        let ids = [];

        $('.record-checkbox:checked').each(function () {

            ids.push($(this).val());

        });

        if (ids.length === 0) {

            toastr.warning('Please select at least one record.');

            return;

        }

        Swal.fire({

            title: 'Delete Selected Blogs?',

            text: "Selected records will be deleted permanently.",

            icon: 'warning',

            showCancelButton: true,

            confirmButtonText: 'Yes, Delete',

            cancelButtonText: 'Cancel',

            customClass: {

                confirmButton: 'btn btn-danger me-2',

                cancelButton: 'btn btn-label-secondary'

            },

            buttonsStyling: false

        }).then((result) => {

            if (result.isConfirmed) {

                $.ajax({

                    url: "{{ route('blogs.bulk-delete') }}",

                    type: "POST",

                    data: {

                        ids: ids

                    },

                    success: function (response) {

                        toastr.success(response.message);

                        $('#checkAll').prop('checked', false);

                        $('#bulkDelete').addClass('d-none');

                        table.ajax.reload();

                    },

                    error: function (xhr) {

                        toastr.error(xhr.responseJSON.message ?? 'Bulk delete failed.');

                    }

                });

            }

        });

    });
    });
</script>
