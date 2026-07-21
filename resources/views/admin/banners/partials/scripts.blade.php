<script>
    $(function () {
        // --------------- CSRF Setup --------------- //
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // --------------- Select2 --------------- //
        $('.select2').select2({
            width: '100%'
        });

        // --------------- DataTable --------------- //
        let table = $('#bannersDatatable').DataTable({

            processing: true,

            serverSide: true,

            responsive: true,

            autoWidth: false,

            pageLength: 10,

            ajax: {

                url: "{{ route('banners.index') }}",

                data: function (d) {

                    d.search = $('#search').val();

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
                    name: 'image',
                    orderable: false,
                    searchable: false
                },

                {
                    data: 'title',
                    name: 'title'
                },

                {
                    data: 'featured',
                    name: 'featured',
                    searchable: false
                },

                {
                    data: 'status',
                    name: 'status',
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

        // --------------- Live Filters --------------- //
        $('#search').keyup(function () {

            table.draw();

        });

        $('#status_filter').change(function () {

            table.draw();

        });

        $('#featured_filter').change(function () {

            table.draw();

        });

        $('#date_from').change(function () {

            table.draw();

        });

        $('#date_to').change(function () {

            table.draw();

        });

        // --------------- Reset Filters --------------- //
        $('#resetFilters').click(function () {

            $('#search').val('');

            $('#status_filter').val('').trigger('change');

            $('#featured_filter').val('').trigger('change');

            $('#date_from').val('');

            $('#date_to').val('');

            table.draw();

        });

        // --------------- Check All --------------- //
        $(document).on('change', '#checkAll', function () {

            $('.record-checkbox').prop('checked', $(this).is(':checked'));

            toggleBulkDelete();

        });

        $(document).on('change', '.record-checkbox', function () {

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

        // --------------- Change Status --------------- //
        $(document).on('change', '.changeStatus', function () {
            $.post("{{ route('banners.change-status') }}", {
                id: $(this).data('id'),
                status: $(this).is(':checked') ? 1 : 0
            }, function (response) {
                toastr.success(response.message);
            });
        });

        // ---------------
        // Change Featured
        // ---------------
        $(document).on('change', '.changeFeatured', function () {

            $.post("{{ route('banners.change-featured') }}", {

                id: $(this).data('id'),

                featured: $(this).is(':checked') ? 1 : 0

            }, function (response) {

                toastr.success(response.message);

            });

        });

        // ---------------
        // Delete Record
        // ---------------
        $(document).on('click', '.deleteRecord', function () {

            let url = $(this).data('url');

            Swal.fire({

                title: 'Are you sure?',

                text: "You won't be able to revert this!",

                icon: 'warning',

                showCancelButton: true,

                confirmButtonText: 'Yes, delete it!'

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

                            toastr.error(xhr.responseJSON?.message ?? 'Something went wrong.');

                        }

                    });

                }

            });

        });

        // ---------------
        // Bulk Delete
        // ---------------
        $('#bulkDelete').click(function () {

            let ids = [];

            $('.record-checkbox:checked').each(function () {

                ids.push($(this).val());

            });

            if (ids.length === 0) {

                toastr.warning('Please select at least one record.');

                return;

            }

            Swal.fire({

                title: 'Delete Selected?',

                text: "Selected banners will be deleted.",

                icon: 'warning',

                showCancelButton: true,

                confirmButtonText: 'Yes, Delete'

            }).then((result) => {

                if (result.isConfirmed) {

                    $.post("{{ route('banners.bulk-delete') }}", {

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
