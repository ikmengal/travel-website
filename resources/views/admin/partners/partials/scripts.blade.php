<script>
    $(function () {
        // -------------------- CSRF -------------------- //
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // -------------------- Select2 -------------------- //
        $('.select2').select2({
            width: '100%'
        });

        // -------------------- DataTable -------------------- //
        let table = $('#partnersTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            autoWidth: false,
            ajax: {
                url: "{{ route('partners.index') }}",
                data: function (d) {
                    d.search = $('#search').val();
                    d.status = $('#status_filter').val();
                    d.featured = $('#featured_filter').val();
                }
            },
            order: [[1, 'desc']],
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
                    data: 'logo',
                    name: 'logo',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'website',
                    name: 'website'
                },
                {
                    data: 'sort_order',
                    name: 'sort_order'
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
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ]
        });

        // -------------------- Search -------------------- //
        $('#search').keyup(function () {
            table.draw();
        });

        // -------------------- Filters -------------------- //
        $('#status_filter, #featured_filter').change(function () {
            table.draw();
        });

        // -------------------- Reset -------------------- //
        $('#resetFilters').click(function () {
            $('#search').val('');
            $('#status_filter').val('').trigger('change');
            $('#featured_filter').val('').trigger('change');
            table.draw();
        });

        // -------------------- Check All -------------------- //
        $(document).on('change', '#checkAll', function () {
            $('.row-checkbox').prop('checked', this.checked);
            toggleBulkDelete();
        });

        $(document).on('change', '.row-checkbox', function () {
            $('#checkAll').prop(
                'checked',
                $('.row-checkbox:checked').length === $('.row-checkbox').length
            );
            toggleBulkDelete();
        });

        // -------------------- Bulk Button -------------------- //
        function toggleBulkDelete() {
            if ($('.row-checkbox:checked').length > 0) {
                $('#bulkDeleteBtn').removeClass('d-none');
            } else {
                $('#bulkDeleteBtn').addClass('d-none');
            }
        }

        // -------------------- Bulk Delete -------------------- //
        $(document).on('click', '#bulkDeleteBtn', function () {
            let ids = [];
            $('.row-checkbox:checked').each(function () {
                ids.push($(this).val());
            });

            if (ids.length === 0) {
                toastr.warning('Please select at least one partner.');
                return;
            }
            Swal.fire({
                title: 'Are you sure?',
                text: 'Selected partners will be deleted permanently.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Delete',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('partners.bulk-delete') }}",
                        type: "POST",
                        data: {
                            ids: ids
                        },
                        success: function (response) {
                            toastr.success(response.message);
                            $('#checkAll').prop('checked', false);
                            $('#bulkDeleteBtn').addClass('d-none');
                            table.ajax.reload(null, false);
                        },
                        error: function (xhr) {
                            toastr.error(xhr.responseJSON.message ?? 'Something went wrong.');
                        }
                    });
                }
            });
        });

        // -------------------- Change Status -------------------- //
        $(document).on('change', '.changeStatus', function () {
            $.ajax({
                url: "{{ route('partners.change-status') }}",
                type: "POST",
                data: {
                    id: $(this).data('id'),
                    status: $(this).is(':checked') ? 1 : 0
                },
                success: function (response) {
                    toastr.success(response.message);
                    table.ajax.reload(null, false);
                },
                error: function () {
                    toastr.error('Unable to update status.');
                }
            });
        });

        // -------------------- Change Featured -------------------- //
        $(document).on('change', '.changeFeatured', function () {
            $.ajax({
                url: "{{ route('partners.change-featured') }}",
                type: "POST",
                data: {
                    id: $(this).data('id'),
                    featured: $(this).is(':checked') ? 1 : 0
                },
                success: function (response) {
                    toastr.success(response.message);
                    table.ajax.reload(null, false);
                },
                error: function () {
                    toastr.error('Unable to update featured status.');
                }
            });
        });

        // -------------------- Delete Single -------------------- //
        $(document).on('click', '.deleteRecord', function () {
            let url = $(this).data('url');
            Swal.fire({
                title: 'Delete Partner?',
                text: 'This action cannot be undone.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Delete',
                cancelButtonText: 'Cancel'
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
                            toastr.error(xhr.responseJSON.message ?? 'Delete failed.');
                        }
                    });
                }
            });
        });
    });
</script>
