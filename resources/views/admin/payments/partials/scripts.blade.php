<script>
    $(function () {
        // --------------- CSRF Token --------------- /
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
        let table = $('#paymentsTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: false,
            searching: false,
            ordering: true,
            autoWidth: false,
            pageLength: 25,
            ajax: {
                url: "{{ route('payments.index') }}",
                data: function (d) {
                    d.loaddata = "yes";
                    d.booking_id = $('booking_filter').val();
                    d.payment_method = $('#method_filter').val();
                    d.payment_status = $('#status_filter').val();
                    d.payment_date = $('#payment_date').val();
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
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'payment_no',
                    name: 'payment_no'
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
                    data: 'payment_method',
                    name: 'payment_method'
                },
                {
                    data: 'gateway',
                    name: 'payment_gateway'
                },
                {
                    data: 'amount',
                    name: 'amount'
                },
                {
                    data: 'currency',
                    name: 'currency'
                },
                {
                    data: 'payment_status',
                    name: 'payment_status'
                },
                {
                    data: 'paid_at',
                    name: 'payment_date'
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
            columnDefs: [
                {
                    targets: [0,1,12],
                    className: 'text-center'
                }
            ],
            drawCallback: function () {
                $('[data-bs-toggle="tooltip"]').tooltip();
            }
        });

        // --------------- Apply Filters --------------- //
        $('#btnFilter').on('click', function () {
            table.ajax.reload();
        });

        // --------------- Search on Enter --------------- //
        $('#search').on('keypress', function (e) {
            if (e.which == 13) {
                table.ajax.reload();
            }
        });

        // --------------- Auto Reload on Filter Change ---------------
        $('#booking_filter').on('change', function () {
            table.ajax.reload();
        });

        $('#method_filter').on('change', function () {
            table.ajax.reload();
        });

        $('#status_filter').on('change', function () {
            table.ajax.reload();
        });

        $('#payment_date').on('change', function () {
            table.ajax.reload();
        });

        // --------------- Reset Filters --------------- //
        $('#btnReset').on('click', function () {
            $('#booking_filter').val('').trigger('change');
            $('#method_filter').val('');
            $('#status_filter').val('');
            $('#payment_date').val('');
            $('#search').val('');
            table.ajax.reload();
        });

        // --------------- Check All --------------- //
        $('#checkAll').on('click', function () {
            $('.checkBoxClass').prop('checked', this.checked);
            toggleBulkDeleteButton();
        });


        $(document).on('click', '.checkBoxClass', function () {
           toggleBulkDeleteButton();
        });

        // --------------- Toggle Bulk Delete Button --------------- //
        function toggleBulkDeleteButton() {
            if ($('.checkBoxClass:checked').length > 0) {
                $('#bulkDelete').removeClass('d-none');
            } else {
                $('#bulkDelete').addClass('d-none');
            }
        }

        // --------------- Delete Payment ---------------
        $(document).on('click', '.deleteRecord', function () {
            let id = $(this).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: "This payment will be deleted permanently.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#696cff',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Delete'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/admin/payments/' + id,
                        type: 'DELETE',
                        success: function (response) {
                            toastr.success(response.message);
                            table.ajax.reload(null, false);
                        },
                        error: function () {
                            toastr.error('Unable to delete payment.');
                        }
                    });
                }
            });
        });

        // --------------- Bulk Delete ---------------
        $('#bulkDelete').on('click', function () {
            let ids = [];
            $('.checkBoxClass:checked').each(function () {
                ids.push($(this).val());
            });
            if (ids.length === 0) {
                toastr.warning('Please select at least one payment.');
                return;
            }

            Swal.fire({
                title: 'Delete Selected Payments?',
                text: "Selected payments will be deleted permanently.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Delete'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('payments.bulk-delete') }}",
                        type: "POST",
                        data: {
                            ids: ids
                        },
                        success: function (response) {
                            toastr.success(response.message);
                            $('#checkAll').prop('checked', false);
                            table.ajax.reload(null, false);
                        },
                        error: function () {
                            toastr.error('Bulk delete failed.');
                        }
                    });
                }
            });
        });

        // --------------- Change Payment Status ---------------
        $(document).on('change', '.changeStatus', function () {
            $.ajax({
                url: "{{ route('payments.change-status') }}",
                type: "POST",
                data: {
                    id: $(this).data('id'),
                    payment_status: $(this).val()
                },
                success: function (response) {
                    toastr.success(response.message);
                    table.ajax.reload(null, false);
                },
                error: function () {
                    toastr.error('Status update failed.');
                }
            });
        });
    });
</script>
