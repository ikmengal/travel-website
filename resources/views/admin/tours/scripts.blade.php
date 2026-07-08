<script>
    $(function () {
        // ------------ Select2 Initialization ------------ //
        initSelect2();
        function initSelect2() {
            $('.select2').each(function () {
                $(this).select2({
                    width: '100%',
                    dropdownParent: $(this).parent()
                });
            });
        }

        // ------------ DataTable ------------ //

        let table = $('#tourTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: false,
            autoWidth: false,
            pageLength: 25,
            searching: false,
            order: [[11, 'desc']],
            ajax: {
                url: "{{ route('tours.index') }}",
                data: function (d) {
                    d.loaddata = "yes";
                    d.destination = $('#destination_filter').val();
                    d.category = $('#category_filter').val();
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
                    data: 'tour',
                    name: 'title'
                },
                {
                    data: 'destination',
                    name: 'destination.name'
                },
                {
                    data: 'category',
                    name: 'category.name'
                },
                {
                    data: 'price',
                    name: 'price'
                },
                {
                    data: 'duration',
                    name: 'duration_days'
                },
                {
                    data: 'rating',
                    name: 'rating'
                },
                {
                    data: 'featured',
                    name: 'featured'
                },
                {
                    data: 'popular',
                    name: 'popular'
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
                    orderable: false,
                    searchable: false
                }
            ],
            language: {
                processing:
                    '<div class="py-4"><div class="spinner-border text-primary"></div></div>',
                emptyTable:
                    '<div class="text-center py-5">' +
                    '<img src="{{ asset("admin/assets/img/illustrations/page-misc-error-light.png") }}" width="180">' +
                    '<h5 class="mt-3">No Tours Found</h5>' +
                    '<p class="text-muted mb-0">Click <b>Add Tour</b> to create your first tour.</p>' +
                    '</div>'
            },
            drawCallback: function () {
                $('[data-bs-toggle="tooltip"]').tooltip();
            }
        });

        // ------------ Destination Filter ------------ //
        $('#destination_filter').change(function () {
            table.draw();
        });


        // ------------ Category Filter ------------ //
        $('#category_filter').change(function () {
            table.draw();
        });

        // ------------ Status Filter ------------ //
        $('#status_filter').change(function () {
            table.draw();
        });

        // ------------ Featured Filter ------------ //
        $('#featured_filter').change(function () {
            table.draw();
        });

        // ------------ Search ------------ //
        let typingTimer;
        $('#search').keyup(function () {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(function () {
                table.draw();
            }, 400);
        });

        // ------------ Reset Filters ------------ //
        $('#resetFilters').click(function () {
            $('#destination_filter').val('').trigger('change');
            $('#category_filter').val('').trigger('change');
            $('#status_filter').val('');
            $('#featured_filter').val('');
            $('#search').val('');
            table.draw();
        });

        // ------------ Refresh Table ------------ //
        $('#refreshTable').click(function () {
            $(this).html(
                '<span class="spinner-border spinner-border-sm me-1"></span>Refreshing'
            );
            table.ajax.reload(null, false);

            setTimeout(() => {
                $('#refreshTable').html(
                    '<i class="ti ti-refresh me-1"></i>Refresh'
                );
            }, 700);
        });


        // ------------ CHECK ALL ------------ //
        $(document).on('change', '#checkAll', function () {
            $('.row-checkbox').prop(
                'checked',
                $(this).is(':checked')
            );
            toggleBulkDelete();
        });

        // ------------ SINGLE CHECKBOX ------------ //
        $(document).on('change', '.row-checkbox', function () {
            toggleBulkDelete();
            if (!$(this).is(':checked')) {
                $('#checkAll').prop('checked', false);
            }
        });

        // ------------ SHOW / HIDE BULK DELETE BUTTON ------------ //
        function toggleBulkDelete() {
            let total = $('.row-checkbox:checked').length;
            if (total > 0) {
                $('#bulkDelete').removeClass('d-none');
                $('#bulkDelete').html(
                    '<i class="ti ti-trash me-1"></i> Delete Selected (' + total + ')'
                );
            } else {
                $('#bulkDelete').addClass('d-none');
                $('#bulkDelete').html(
                    '<i class="ti ti-trash me-1"></i> Delete Selected'
                );
            }
        }

        // ------------ BULK DELETE ------------ //
        $(document).on('click', '#bulkDelete', function () {
            let ids = [];
            $('.row-checkbox:checked').each(function () {
                ids.push($(this).val());
            });

            if (ids.length === 0) {
                toastr.warning('Please select at least one record.');
                return;
            }

            Swal.fire({
                title: 'Delete Selected Tours?',
                text: "This action cannot be undone.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#8592a3',
                confirmButtonText: 'Yes, Delete'
            }).then((result) => {
                if (!result.isConfirmed) return;
                $.ajax({
                    url: "{{ route('tours.bulk-delete') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        ids: ids
                    },
                    beforeSend: function () {
                        $('#bulkDelete')
                            .prop('disabled', true)
                            .html(
                                '<span class="spinner-border spinner-border-sm me-1"></span>Deleting...'
                            );
                    },
                    success: function (response) {
                        toastr.success(response.message);
                        table.ajax.reload(null, false);
                        $('#checkAll').prop('checked', false);
                        $('#bulkDelete')
                            .addClass('d-none')
                            .prop('disabled', false)
                            .html(
                                '<i class="ti ti-trash me-1"></i> Delete Selected'
                            );
                    },
                    error: function () {
                        toastr.error('Something went wrong.');
                        $('#bulkDelete')
                            .prop('disabled', false)
                            .html(
                                '<i class="ti ti-trash me-1"></i> Delete Selected'
                            );
                    }
                });
            });
        });

        // ------------ STATUS TOGGLE ------------ //
        $(document).on('change', '.changeStatus', function () {
            let id = $(this).data('id');
            let checkbox = $(this);

            $.ajax({
                url: "{{ route('tours.change-status') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id
                },
                beforeSend: function () {
                    checkbox.prop('disabled', true);
                },
                success: function (response) {
                    toastr.success(response.message);
                    table.ajax.reload(null, false);
                },
                error: function () {
                    toastr.error('Unable to update status.');
                    table.ajax.reload(null, false);
                },
                complete: function () {
                    checkbox.prop('disabled', false);
                }
            });
        });

        // ------------ FEATURED TOGGLE ------------ //
        $(document).on('change', '.changeFeatured', function () {
            let id = $(this).data('id');

            let checkbox = $(this);

            $.ajax({

                url: "{{ route('tours.change-featured') }}",

                type: "POST",

                data: {
                    _token: "{{ csrf_token() }}",
                    id: id
                },

                beforeSend: function () {

                    checkbox.prop('disabled', true);

                },

                success: function (response) {

                    toastr.success(response.message);

                    table.ajax.reload(null, false);

                },

                error: function () {

                    toastr.error('Unable to update featured status.');

                    table.ajax.reload(null, false);

                },

                complete: function () {

                    checkbox.prop('disabled', false);

                }

            });

        });


        // ============================================
        // POPULAR TOGGLE
        // ============================================

        $(document).on('change', '.changePopular', function () {

            let id = $(this).data('id');

            let checkbox = $(this);

            $.ajax({

                url: "{{ route('tours.change-popular') }}",

                type: "POST",

                data: {
                    _token: "{{ csrf_token() }}",
                    id: id
                },

                beforeSend: function () {

                    checkbox.prop('disabled', true);

                },

                success: function (response) {

                    toastr.success(response.message);

                    table.ajax.reload(null, false);

                },

                error: function () {

                    toastr.error('Unable to update popular status.');

                    table.ajax.reload(null, false);

                },

                complete: function () {

                    checkbox.prop('disabled', false);

                }

            });

        });


        // ============================================
        // SINGLE DELETE
        // ============================================

        $(document).on('click', '.deleteRecord', function (e) {

            e.preventDefault();

            let url = $(this).data('url');

            Swal.fire({

                title: 'Delete Tour?',

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

                    beforeSend: function () {

                        Swal.showLoading();

                    },

                    success: function (response) {

                        Swal.close();

                        toastr.success(response.message);

                        table.ajax.reload(null, false);

                    },

                    error: function () {

                        Swal.close();

                        toastr.error('Delete failed.');

                    }

                });

            });

        });


        // ============================================
        // RELOAD SELECT2 AFTER DATATABLE DRAW
        // ============================================

        table.on('draw', function () {

            $('[data-bs-toggle="tooltip"]').tooltip();

            initSelect2();

        });


        // ============================================
        // AUTO REFRESH EVERY 5 MINUTES (OPTIONAL)
        // ============================================

        /*
        setInterval(function () {

            table.ajax.reload(null, false);

        }, 300000);
        */


        // ============================================
        // ESC KEY CLEAR SEARCH
        // ============================================

        $('#search').on('keydown', function (e) {

            if (e.key === 'Escape') {

                $(this).val('');

                table.draw();

            }

        });


        // ============================================
        // ENTER KEY SEARCH
        // ============================================

        $('#search').keypress(function (e) {

            if (e.which === 13) {

                table.draw();

            }

        });


        // ============================================
        // RESET DATATABLE STATE
        // ============================================

        $('#resetFilters').click(function () {

            $('#checkAll').prop('checked', false);

            $('.row-checkbox').prop('checked', false);

            $('#bulkDelete').addClass('d-none');

        });

    });
</script>
