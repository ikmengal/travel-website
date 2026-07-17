<script>
    $(function () {
        // -------------- CSRF -------------- //
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // -------------- DATATABLE -------------- //
        let table = $('.datatable').DataTable({
            processing: true,
            serverSide: true,
            responsive: false,
            autoWidth: false,
            order: [[1, 'desc']],
            ajax: {
                url: "{{ route('newsletter_subscribers.index') }}",
                data: function (d) {
                    d.status = $('#status_filter').val();
                    d.verified = $('#verified_filter').val();
                    d.subscribed_date = $('#subscribed_date_filter').val();
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
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'verified_at',
                    name: 'verified_at'
                },
                {
                    data: 'subscribed_at',
                    name: 'subscribed_at'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ]
        });

        // -------------- FILTERS -------------- //
        $('#status_filter,#verified_filter').change(function () {
            table.ajax.reload();
        });

        $('#subscribed_date_filter').change(function () {
            table.ajax.reload();
        });

        // -------------- REFRESH -------------- //
        $('#refreshFilters').click(function () {
            $('#status_filter').val('').trigger('change');
            $('#verified_filter').val('').trigger('change');
            $('#subscribed_date_filter').val('');

            $('#checkAll').prop('checked', false);

            table.ajax.reload();
        });

        // -------------- CHECK ALL -------------- //
        $(document).on('change','#checkAll',function(){
            $('.checkBoxClass').prop('checked',$(this).is(':checked'));
            toggleBulkDelete();
        });

        // -------------- SINGLE CHECKBOX -------------- //
        $(document).on('change','.checkBoxClass',function(){
            let total = $('.checkBoxClass').length;
            let checked = $('.checkBoxClass:checked').length;

            $('#checkAll').prop('checked', total > 0 && total === checked);
            toggleBulkDelete();
        });

        // -------------- BULK BUTTON -------------- //
        function toggleBulkDelete(){
            if($('.checkBoxClass:checked').length > 0){
                $('#bulkDelete').removeClass('d-none');
            }else{
                $('#bulkDelete').addClass('d-none');
            }
        }

        // -------------- DRAW -------------- //
        table.on('draw',function(){
            $('#checkAll').prop('checked',false);
            $('#bulkDelete').addClass('d-none');
        });

        // -------------- CHANGE STATUS -------------- //
        $(document).on('change', '.changeStatus', function () {
            let id = $(this).data('id');

            $.ajax({
                url: "{{ route('newsletter_subscribers.change-status') }}",
                type: "POST",
                data: {
                    id: id
                },
                success: function (response) {
                    toastr.success(response.message);
                    table.ajax.reload(null, false);
                },
                error: function (xhr) {
                    if (xhr.status === 422) {
                        $.each(xhr.responseJSON.errors, function (key, value) {

                            $('.' + key + '_error').text(value[0]);

                        });
                    } else {
                        toastr.error(xhr.responseJSON?.message ?? 'Something went wrong.');
                    }
                }
            });
        });

        // -------------- DELETE -------------- //
        $(document).on('click', '.deleteRecord', function () {
            let id = $(this).data('id');

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                confirmButtonColor: '#696cff',
                cancelButtonColor: '#8592a3'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('newsletter_subscribers.destroy', ':id') }}".replace(':id', id),
                        type: "DELETE",
                        success: function (response) {
                            toastr.success(response.message);
                            table.ajax.reload(null, false);
                        },
                        error: function (xhr) {
                            toastr.error(xhr.responseJSON.message ?? 'Something went wrong.');
                        }
                    });
                }
            });
        });

        // -------------- BULK DELETE -------------- //
        $('#bulkDelete').click(function () {
            let ids = [];

            $('.checkBoxClass:checked').each(function () {
                ids.push($(this).val());
            });

            if (ids.length === 0) {
                toastr.warning('Please select at least one subscriber.');
                return;
            }

            Swal.fire({
                title: 'Are you sure?',
                text: 'Selected subscribers will be deleted!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete them!',
                confirmButtonColor: '#696cff',
                cancelButtonColor: '#8592a3'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('newsletter_subscribers.bulk-delete') }}",
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
                            toastr.error(xhr.responseJSON.message ?? 'Something went wrong.');
                        }
                    });
                }
            });
        });
    });
</script>
