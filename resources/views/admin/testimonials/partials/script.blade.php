<script>
    $(function() {
        // ------------ CSRF ------------ //
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // ------------ Select2 ------------ //
        $('.select2').select2({
            width: '100%'
        });

        // ------------ DataTable ------------ //
        let table = $('#testimonialsDatatable').DataTable({
            processing: true,
            serverSide: true,
            responsive: false,
            autoWidth: false,
            ordering: true,
            searching: false,
            lengthChange: true,
            pageLength: 10,

            lengthMenu: [
                [10, 25, 50, 100],
                [10, 25, 50, 100]
            ],
            ajax: {
                url: "{{ route('testimonials.index') }}",
                type: "GET",
                data: function(d) {
                    d.search = $('#search').val();
                    d.status = $('#status_filter').val();
                    d.featured = $('#featured_filter').val();
                    d.rating = $('#rating_filter').val();
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
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'customer',
                    name: 'customer',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'company',
                    name: 'company'
                },
                {
                    data: 'rating',
                    name: 'rating',
                    searchable: false
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
            ],
            order: [
                [8, 'desc']
            ],
            drawCallback: function() {
                $('#checkAll').prop('checked', false);
                $('#bulkDelete').addClass('d-none');
            }
        });

        // ------------ Search  ------------ //
        $('#search').keyup(function() {
            table.draw();
        });

        // ------------ Filters ------------ //
        $('#status_filter,#featured_filter,#rating_filter,#date_from,#date_to')
            .change(function() {
                table.draw();
            });

        // ------------ Refresh ------------ //
        $('#refreshTable').click(function() {
            $('#search').val('');
            $('#date_from').val('');
            $('#date_to').val('');
            $('#status_filter').val('').trigger('change');
            $('#featured_filter').val('').trigger('change');
            $('#rating_filter').val('').trigger('change');
            table.ajax.reload();
        });

        // ------------  Reset Filters  ------------ //
        $('#resetFilter').click(function() {
            $('#search').val('');
            $('#date_from').val('');
            $('#date_to').val('');

            $('#status_filter').val('').trigger('change');
            $('#featured_filter').val('').trigger('change');
            $('#rating_filter').val('').trigger('change');
            table.draw();
        });

        // ------------ Check All ------------ //
        $(document).on('change', '#checkAll', function() {
            $('.checkBoxClass').prop('checked', $(this).is(':checked'));
            toggleBulkDelete();
        });

        // ------------ Single Checkbox ------------ //
        $(document).on('change', '.checkBoxClass', function() {
            toggleBulkDelete();
        });

        // ------------ Bulk Delete Button ------------ //
        function toggleBulkDelete() {
            let total = $('.checkBoxClass:checked').length;
            if (total > 0) {
                $('#bulkDelete').removeClass('d-none');
            } else {
                $('#bulkDelete').addClass('d-none');
            }
        }

        // ------------ Status Change ------------ //
        $(document).on('change', '.changeStatus', function () {
            let id = $(this).data('id');
            let status = $(this).is(':checked') ? 1 : 0;

            $.ajax({
                url: "{{ route('testimonials.change-status') }}",
                type: "POST",
                data: {
                    id: id,
                    status: status
                },
                success: function (response) {
                    toastr.success(response.message);
                    table.ajax.reload(null, false);
                },
                error: function (xhr) {
                    toastr.error(xhr.rsponseJSON?.message ?? 'Something went wrong.');
                    table.ajax.reload(null, false);
                }
            });
        });

        // $(document).on('change', '.changeStatus', function () {
        //     let id = $(this).data('id');
        //     let status = $(this).is(':checked') ? 1 : 0;

        //     $.ajax({
        //         url: "{{ route('testimonials.change-status') }}",
        //         type: "POST",
        //         data: {
        //             id: id,
        //             status: status
        //         },
        //         success: function (response) {
        //             toastr.success(response.message);
        //             table.ajax.reload(null, false);
        //         },
        //         error: function (xhr) {
        //             toastr.error(xhr.responseJSON?.message ?? 'Something went wrong.');
        //             table.ajax.reload(null, false);
        //         }
        //     });
        // });

        // ------------ Featured Change ------------ //
        $(document).on('change', '.changeFeatured', function () {
            let id = $(this).data('id');
            let featured = $(this).is(':checked') ? 1 : 0;

            $.ajax({
                url: "{{ route('testimonials.change-featured') }}",
                type: "POST",
                data: {
                    id: id,
                    featured: featured
                },
                success: function (response) {
                    toastr.success(response.message);
                    table.ajax.reload(null, false);
                },
                error: function (xhr) {
                    toastr.error(xhr.responseJSON?.message ?? 'Something went wrong.');
                    table.ajax.reload(null, false);
                }
            });
        });

        // ------------ Delete Record ------------ //
        $(document).on('click', '.deleteRecord', function () {
            let id = $(this).data('id');

            Swal.fire({
                title: 'Delete Testimonial?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#696cff',
                cancelButtonColor: '#8592a3',
                confirmButtonText: 'Yes, Delete'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "/testimonials/" + id,
                        type: "DELETE",
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
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

        // ------------ Bulk Delete ------------ //
        $('#bulkDelete').click(function () {
            let ids = [];
            $('.checkBoxClass:checked').each(function () {
                ids.push($(this).val());
            });
            if (ids.length === 0) {
                toastr.warning('Please select at least one testimonial.');
                return;
            }
            Swal.fire({
                title: 'Delete Selected Testimonials?',
                text: "Selected testimonials will be permanently deleted.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#696cff',
                cancelButtonColor: '#8592a3',
                confirmButtonText: 'Yes, Delete'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('testimonials.bulk-delete') }}",
                        type: "POST",
                        data: {
                            ids: ids
                        },
                        success: function (response) {
                            toastr.success(response.message);
                            $('#checkAll').prop('checked', false);
                            $('#bulkDelete').addClass('d-none');
                            table.ajax.reload(null, false);
                        },
                        error: function (xhr) {
                            toastr.error(
                                xhr.responseJSON?.message ??
                                'Something went wrong.'
                            );
                        }
                    });
                }
            });
        });

        // ------------ Auto Reload After Select2 Clear ------------ //
        $('#status_filter, #featured_filter, #rating_filter') .on('select2:clear', function () {
            table.draw();
        });
    });
</script>
