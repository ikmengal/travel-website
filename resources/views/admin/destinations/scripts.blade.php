<script>
    $(function () {
        selectInit();
        let table = $('#destinationTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: false,
            autoWidth: false,
            pageLength: 25,
            order: [[9, 'desc']],
            ajax: {
                url: "{{ route('destinations.index') }}",
                data: function (d) {
                    d.loaddata = "yes";
                    d.country = $('#country_filter').val();
                    d.status = $('#status_filter').val();
                    d.featured = $('#featured_filter').val();
                    d.search = $('#search').val();
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
                    data: 'image',
                    name: 'featured_image',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'destination',
                    name: 'name'
                },
                {
                    data: 'country',
                    name: 'country.name'
                },
                {
                    data: 'tours',
                    name: 'tours_count'
                },
                {
                    data: 'hotels',
                    name: 'hotels_count'
                },
                {
                    data: 'featured',
                    name: 'is_featured'
                },
                {
                    data: 'popular',
                    name: 'is_popular'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'action',
                    name: 'action',
                }
            ]
        });

        // --------------------- Filters --------------------- //
        $('#country_filter').change(function () {
            table.draw();
        });

        $('#status_filter').change(function () {
            table.draw();
        });

        $('#featured_filter').change(function () {
            table.draw();
        });

        $('#search').keyup(function () {
            table.draw();
        });

        // --------------------- Refresh --------------------- //
        $('#refreshTable').click(function () {
            table.ajax.reload(null,false);
        });

        // --------------------- Check All --------------------- //
        $(document).on('change', '#checkAll', function () {
            $('.row-checkbox').prop('checked', $(this).is(':checked'));
            toggleBulkDelete();
        });

        $(document).on('change', '.row-checkbox', function () {
            toggleBulkDelete();

            if (!$(this).is(':checked')) {
                $('#checkAll').prop('checked', false);
            }
        });

        function toggleBulkDelete() {
            let total = $('.row-checkbox:checked').length;

            if (total > 0) {
                $('#bulkDelete').removeClass('d-none');
            } else {
                $('#bulkDelete').addClass('d-none');
            }
        }

        // --------------------- Bulk Delete --------------------- //
        $(document).on('click', '#bulkDelete', function () {
            let ids = [];

            $('.row-checkbox:checked').each(function () {
                ids.push($(this).val());
            });

            if (ids.length == 0) {
                return;
            }

            Swal.fire({
                title: 'Delete Selected Destinations?',
                text: "This action cannot be undone.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#8592a3',
                confirmButtonText: 'Yes, Delete'
            }).then((result) => {
                if (!result.isConfirmed) return;

                $.ajax({
                    url: "{{ route('destinations.bulk-delete') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        ids: ids
                    },
                    beforeSend: function () {
                        $('#bulkDelete')
                            .prop('disabled', true)
                            .html('<span class="spinner-border spinner-border-sm"></span>');
                    },
                    success: function (response) {
                        toastr.success(response.message);
                        table.ajax.reload(null, false);
                        $('#checkAll').prop('checked', false);
                        $('#bulkDelete').addClass('d-none');
                    },
                    error: function () {
                        toastr.error('Something went wrong.');
                    },
                    complete: function () {
                        $('#bulkDelete')
                            .prop('disabled', false)
                            .html('<i class="ti ti-trash"></i> Delete Selected');
                    }
                });
            });
        });

        // --------------------- Status Toggle --------------------- //
        $(document).on('change', '.changeStatus', function () {
            let id = $(this).data('id');

            $.ajax({
                url: "{{ route('destinations.change-status') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id
                },
                success: function (response) {
                    toastr.success(response.message);
                    table.ajax.reload(null, false);
                },
                error: function () {
                    console.log(xhr);
                    console.log(xhr.responseText);
                    console.log(xhr.responseJSON);

                    toastr.error("Unable to update status.");

                    table.ajax.reload(null, false);
                }
            });
        });

        // --------------------- Single Delete --------------------- //
        $(document).on('click', '.deleteRecord', function (e) {
            e.preventDefault();
            let url = $(this).data('url');

            Swal.fire({
                title: 'Delete Destination?',
                text: 'This action cannot be undone.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#8592a3',
                confirmButtonText: 'Delete'
            }).then((result) => {
                if (!result.isConfirmed) return;
                $.ajax({
                    url: url,
                    type: "DELETE",
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        toastr.success(response.message);
                        table.ajax.reload(null, false);
                    },
                    error: function () {
                        toastr.error('Delete failed.');
                    }
                });
            });
        });

        function selectInit() {
            setTimeout(() => {
                $('select').each(function() {
                    $(this).select2({
                        dropdownParent: $(this).parent(),
                    });
                });
            }, 1000);
        }
    });
</script>
