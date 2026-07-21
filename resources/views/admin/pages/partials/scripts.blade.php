<script>
    $(function () {

        // =====================================================
        // CSRF Setup
        // =====================================================

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // =====================================================
        // Select2
        // =====================================================

        $('.select2').select2({
            width: '100%'
        });

        // =====================================================
        // DataTable
        // =====================================================

        let table = $('#pagesDatatable').DataTable({

            processing: true,

            serverSide: true,

            responsive: true,

            autoWidth: false,

            pageLength: 10,

            order: [[8, 'desc']],

            ajax: {

                url: "{{ route('pages.index') }}",

                data: function (d) {

                    d.search = $('#search').val();

                    d.page_type = $('#page_type_filter').val();

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
                    orderable: false,
                    searchable: false
                },

                {
                    data: 'image',
                    name: 'image',
                    orderable: false,
                    searchable: false
                },

                {
                    data: 'title',
                    name: 'title'
                },

                {
                    data: 'page_type',
                    name: 'page_type'
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
                    data: 'sort_order',
                    name: 'sort_order'
                },

                {
                    data: 'created_at',
                    name: 'created_at'
                },

                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }

            ]

        });

        // =====================================================
        // Live Search
        // =====================================================

        $('#search').on('keyup', function () {

            table.draw();

        });

        // =====================================================
        // Filters
        // =====================================================

        $('#page_type_filter').on('change', function () {

            table.draw();

        });

        $('#status_filter').on('change', function () {

            table.draw();

        });

        $('#featured_filter').on('change', function () {

            table.draw();

        });

        $('#date_from').on('change', function () {

            table.draw();

        });

        $('#date_to').on('change', function () {

            table.draw();

        });

                // =====================================================
        // Reset Filters
        // =====================================================

        $('#resetFilters').on('click', function () {

            $('#search').val('');

            $('#page_type_filter').val('').trigger('change');

            $('#status_filter').val('').trigger('change');

            $('#featured_filter').val('').trigger('change');

            $('#date_from').val('');

            $('#date_to').val('');

            $('#checkAll').prop('checked', false);

            $('#bulkDelete').addClass('d-none');

            table.draw();

        });

        // =====================================================
        // Check All
        // =====================================================

        $(document).on('change', '#checkAll', function () {

            $('.record-checkbox').prop('checked', $(this).is(':checked'));

            toggleBulkDelete();

        });

        $(document).on('change', '.record-checkbox', function () {

            $('#checkAll').prop(
                'checked',
                $('.record-checkbox').length === $('.record-checkbox:checked').length
            );

            toggleBulkDelete();

        });

        function toggleBulkDelete() {

            let count = $('.record-checkbox:checked').length;

            if (count > 0) {

                $('#bulkDelete').removeClass('d-none');

            } else {

                $('#bulkDelete').addClass('d-none');

            }

        }

        // =====================================================
        // Change Status
        // =====================================================

        $(document).on('change', '.changeStatus', function () {

            $.post("{{ route('pages.change-status') }}", {

                id: $(this).data('id'),

                status: $(this).is(':checked') ? 1 : 0

            }, function (response) {

                toastr.success(response.message);

            });

        });

        // =====================================================
        // Change Featured
        // =====================================================

        $(document).on('change', '.changeFeatured', function () {

            $.post("{{ route('pages.change-featured') }}", {

                id: $(this).data('id'),

                featured: $(this).is(':checked') ? 1 : 0

            }, function (response) {

                toastr.success(response.message);

            });

        });

        // =====================================================
        // Delete Record
        // =====================================================

        $(document).on('click', '.deleteRecord', function () {

            let url = $(this).data('url');

            Swal.fire({

                title: 'Are you sure?',

                text: "This page will be permanently deleted.",

                icon: 'warning',

                showCancelButton: true,

                confirmButtonText: 'Yes, Delete',

                cancelButtonText: 'Cancel'

            }).then((result) => {

                if (result.isConfirmed) {

                    $.ajax({

                        url: url,

                        type: 'DELETE',

                        success: function (response) {

                            toastr.success(response.message);

                            table.ajax.reload(null, false);

                        },

                        error: function (xhr) {

                            toastr.error(
                                xhr.responseJSON?.message ?? 'Something went wrong.'
                            );

                        }

                    });

                }

            });

        });

        // =====================================================
        // Bulk Delete
        // =====================================================

        $('#bulkDelete').on('click', function () {

            let ids = [];

            $('.record-checkbox:checked').each(function () {

                ids.push($(this).val());

            });

            if (!ids.length) {

                toastr.warning('Please select at least one page.');

                return;

            }

            Swal.fire({

                title: 'Delete Selected Pages?',

                text: "Selected pages will be permanently deleted.",

                icon: 'warning',

                showCancelButton: true,

                confirmButtonText: 'Yes, Delete',

                cancelButtonText: 'Cancel'

            }).then((result) => {

                if (result.isConfirmed) {

                    $.post("{{ route('pages.bulk-delete') }}", {

                        ids: ids

                    }, function (response) {

                        toastr.success(response.message);

                        $('#checkAll').prop('checked', false);

                        $('#bulkDelete').addClass('d-none');

                        table.ajax.reload(null, false);

                    });

                }

            });

        });

    });
</script>
