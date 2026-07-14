<script>
    $(function () {
        // -------------- CSRF -------------- //
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // -------------- DataTable -------------- //
        let table = $('#travelerTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: false,
            autoWidth: false,
            pageLength: 25,
            order: [[11, 'desc']],
            ajax: {
                url: "{{ route('booking_travelers.index') }}",
                data: function (d) {
                    d.loaddata = "yes";
                    d.booking_id = $('#booking_filter').val();
                    d.gender = $('#gender_filter').val();
                    d.nationality = $('#nationality_filter').val();
                    d.status = $('#status_filter').val();
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
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    searchable: false
                },
                {
                    data: 'traveler',
                    name: 'full_name'
                },
                {
                    data: 'booking',
                    name: 'booking.booking_no'
                },
                {
                    data: 'customer',
                    name: 'booking.user.name'
                },
                {
                    data: 'tour',
                    name: 'booking.tour.title'
                },
                {
                    data: 'gender',
                    name: 'gender'
                },
                {
                    data: 'nationality',
                    name: 'nationality'
                },
                {
                    data: 'passport_number',
                    name: 'passport_no'
                },
                {
                    data: 'phone',
                    name: 'phone'
                },
                {
                    data: 'status',
                    name: 'status',
                    orderable: false,
                    searchable: false
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

        // -------------- Search / Filters -------------- //
        $('#btnFilter').on('click', function () {
            table.ajax.reload();
        });

        $('#search').on('keyup', function (e) {
            if (e.keyCode == 13) {
                table.ajax.reload();
            }
        });

        $('#booking_filter').on('change', function () {
            table.ajax.reload();
        });

        $('#gender_filter').on('change', function () {
            table.ajax.reload();
        });

        $('#status_filter').on('change', function () {
            table.ajax.reload();
        });

        $('#nationality_filter').on('keyup', function () {
            table.ajax.reload();
        });

        // -------------- Reset Filters -------------- //
        $('#btnReset').on('click', function () {
            $('#booking_filter').val('').trigger('change');

            $('#gender_filter').val('');

            $('#nationality_filter').val('');

            $('#status_filter').val('');

            $('#search').val('');

            table.ajax.reload();
        });

        // -------------- Check All -------------- //
        $('#checkAll').on('click', function () {
            $('.checkBoxClass').prop('checked', $(this).is(':checked'));
        });

        $(document).on('change', '.checkBoxClass', function () {
            if (!$(this).is(':checked')) {
                $('#checkAll').prop('checked', false);
            }
        });

        // -------------- Delete -------------- //
        $(document).on('click', '.deleteRecord', function () {
            let id = $(this).data('id');

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: 'booking_travelers.delete,' + id,
                        type: 'DELETE',
                        success: function (response) {
                            toastr.success(response.message);
                            table.ajax.reload(null, false);
                        },
                        error: function () {
                            toastr.error('Something went wrong.');
                        }
                    });
                }
            });
        });

        // -------------- Bulk Delete -------------- //
        $('#bulkDelete').on('click', function () {
            let ids = [];

            $('.checkBoxClass:checked').each(function () {
                ids.push($(this).val());
            });

            if (ids.length === 0) {
                toastr.warning('Please select at least one record.');
                return;
            }
            Swal.fire({
                title: 'Delete selected records?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Delete'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('booking_travelers.bulk-delete') }}",
                        type: 'POST',
                        data: {
                            ids: ids
                        },
                        success: function (response) {
                            $('#checkAll').prop('checked', false);
                            toastr.success(response.message);
                            table.ajax.reload(null, false);
                        },
                        error: function () {
                            toastr.error('Bulk delete failed.');
                        }
                    });
                }
            });
        });

        // -------------- Status Change -------------- //
        $(document).on('change', '.changeStatus', function () {
            $.ajax({
                url: "{{ route('booking_travelers.change-status') }}",
                type: 'POST',
                data: {
                    id: $(this).data('id'),
                    status: $(this).is(':checked') ? 1 : 0
                },
                success: function (response) {
                    toastr.success(response.message);
                },
                error: function () {
                    toastr.error('Unable to update status.');
                }
            });
        });
    });
</script>
