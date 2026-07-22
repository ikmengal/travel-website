<script>
    $(function () {
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
        let table = $('#galleryTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            autoWidth: false,
            ajax: {
                url: "{{ route('gallery.index') }}",
                data: function (d) {
                    d.search = $('#search').val();
                    d.category = $('#category_filter').val();
                    d.featured = $('#featured_filter').val();
                    d.status = $('#status_filter').val();
                }
            },
            order: [[7, 'asc']],
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
                    data: 'category',
                    name: 'category'
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
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ]
        });

        // ------------ Filters ------------ //
        $('#search').keyup(function () {
            table.draw();
        });

        $('#category_filter').change(function () {
            table.draw();
        });

        $('#featured_filter').change(function () {
            table.draw();
        });

        $('#status_filter').change(function () {
            table.draw();
        });

        // ------------ Reset Filters ------------ //
        $('#resetFilters').click(function () {
            $('#search').val('');
            $('#category_filter').val('').trigger('change');
            $('#featured_filter').val('').trigger('change');
            $('#status_filter').val('').trigger('change');
            table.draw();
        });

        // ------------ Check All ------------ //
        $('#checkAll').change(function () {
            $('.row-checkbox').prop('checked', $(this).prop('checked'));
            toggleBulkDelete();
        });

        $(document).on('change', '.row-checkbox', function () {
            toggleBulkDelete();
        });

        function toggleBulkDelete() {
            let count = $('.row-checkbox:checked').length;
            if (count > 0) {
                $('#bulkDeleteBtn').removeClass('d-none');
            } else {
                $('#bulkDeleteBtn').addClass('d-none');
            }
        }

        // ------------ Status Change ------------ //
        $(document).on('change', '.status-switch', function () {
            $.post("{{ route('gallery.change-status') }}", {
                id: $(this).data('id'),
                status: $(this).is(':checked') ? 1 : 0
            }, function (response) {
                toastr.success(response.message);
            });
        });

        // ------------ Featured Change ------------ //
        $(document).on('change', '.featured-switch', function () {
            $.post("{{ route('gallery.change-featured') }}", {
                id: $(this).data('id'),
                featured: $(this).is(':checked') ? 1 : 0
            }, function (response) {
                toastr.success(response.message);
            });
        });

        // ------------ Delete ------------ //
        $(document).on('click', '.deleteGallery', function () {
            let url = $(this).data('url');
            Swal.fire({
                title: 'Delete Gallery?',
                text: "This action cannot be undone.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Delete',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        success: function (response) {
                            toastr.success(response.message);
                            table.draw(false);
                        }
                    });
                }
            });
        });

        // ------------ Bulk Delete ------------ //
        $('#bulkDeleteBtn').click(function () {
            let ids = [];
            $('.row-checkbox:checked').each(function () {
                ids.push($(this).val());
            });

            if (ids.length == 0)
                return;

            Swal.fire({
                title: 'Delete Selected?',
                text: "Selected records will be deleted.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Delete'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.post("{{ route('gallery.bulk-delete') }}", {
                        ids: ids
                    }, function (response) {
                        $('#checkAll').prop('checked', false);
                        $('#bulkDeleteBtn').addClass('d-none');
                        toastr.success(response.message);
                        table.draw(false);
                    });
                }
            });
        });
    });
</script>
