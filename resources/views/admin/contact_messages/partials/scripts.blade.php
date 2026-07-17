<script>
    $(function () {
        // --------------- CKEDITOR --------------- //
        CKEDITOR.replace('reply', {
            height: 250
        });

        // ---------------- CSRF Token ---------------- //
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // ---------------- Select2 ---------------- //
        $('.select2').select2({
            width: '100%'
        });

        // ---------------- DataTable ---------------- //
        let table = $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            responsive: false,
            autoWidth: false,
            searching: true,
            ordering: true,
            pageLength: 10,
            lengthMenu: [
                [10, 25, 50, 100],
                [10, 25, 50, 100]
            ],
            ajax: {
                url: "{{ route('contact_messages.index') }}",
                type: "GET",
                data: function (d) {
                    d.loaddata = 'yes';
                    d.status = $('#status_filter').val();
                    d.is_read = $('#read_filter').val();
                    d.is_replied = $('#reply_filter').val();
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
                    data: 'user',
                    name: 'user.name'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'subject',
                    name: 'subject'
                },
                {
                    data: 'read_status',
                    name: 'is_read',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'reply_status',
                    name: 'is_replied',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'status',
                    name: 'status',
                    orderable: false,
                    searchable: false,
                    width: '170px'
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
                [10, 'desc']
            ],
            drawCallback: function () {
                $('#checkAll').prop('checked', false);
                $('#bulkDelete').addClass('d-none');
                $('.changeStatus').select2({
                    minimumResultsForSearch: Infinity,
                    width: '100%'
                });
            }
        });

        // ---------------- Filters ---------------- //
        $('#status_filter, #read_filter, #reply_filter, #date_from, #date_to').on('change', function () {
            table.ajax.reload();
        });

        $('#refreshTable').click(function(){
            table.ajax.reload();
        });

        $('#resetFilter').click(function () {
            $('#status_filter').val('').trigger('change');
            $('#read_filter').val('').trigger('change');
            $('#reply_filter').val('').trigger('change');
            $('#date_from').val('');
            $('#date_to').val('');
            table.ajax.reload();
        })

        // ---------------- Select All ---------------- //
        $(document).on('change', '#checkAll', function () {
            $('.checkBoxClass').prop('checked', $(this).prop('checked'));
            $('#bulkDelete').toggleClass(
                'd-none',
                $('.checkBoxClass:checked').length === 0
            );
        });

        // ---------------- Single Checkbox ---------------- //
        $(document).on('change', '.checkBoxClass', function () {
            $('#checkAll').prop(
                'checked',
                $('.checkBoxClass').length === $('.checkBoxClass:checked').length
            );

            $('#bulkDelete').toggleClass(
                'd-none',
                $('.checkBoxClass:checked').length === 0
            );
        });

        // ---------------- Change Status ---------------- //
        // $(document).on('change', '.changeStatus', function () {
        //     let id = $(this).data('id');
        //     let status = $(this).is(':checked') ? 1 : 0;

        //     $.ajax({
        //         url: "{{ route('contact_messages.change-status') }}",
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
        //             toastr.error(
        //                 xhr.responseJSON?.message ?? 'Something went wrong.'
        //             );
        //             table.ajax.reload(null, false);
        //         }
        //     });
        // });

        $(document).on('change', '.changeStatus', function () {
            let id = $(this).data('id');
            let status = $(this).val();

            $.ajax({
                url: "{{ route('contact_messages.change-status') }}",
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
                    toastr.error(xhr.responseJSON?.message ?? 'Something went wrong.');
                    table.ajax.reload(null, false);
                }
            });

        });

        // ---------------- Change Read Status ---------------- //
        $(document).on('click', '.toggleRead', function () {
            let id = $(this).data('id');

            $.ajax({
                url: "{{ route('contact_messages.change-read-status') }}",
                type: "POST",
                data: {
                    id: id
                },
                success: function (response) {
                    toastr.success(response.message);
                    table.ajax.reload(null, false);
                },
                error: function (xhr) {
                    toastr.error(xhr.responseJSON.message ?? 'Something went wrong.');
                }
            });
        });

        // ---------------- Change Reply Status ---------------- //
        $(document).on('change', '.changeReplyStatus', function () {
            let id = $(this).data('id');
            let is_replied = $(this).is(':checked') ? 1 : 0;

            $.ajax({
                url: "{{ route('contact_messages.change-reply-status') }}",
                type: "POST",
                data: {
                    id: id,
                    is_replied: is_replied
                },
                success: function (response) {
                    toastr.success(response.message);
                    table.ajax.reload(null, false);
                },
                error: function (xhr) {
                    toastr.error(
                        xhr.responseJSON?.message ?? 'Something went wrong.'
                    );
                    table.ajax.reload(null, false);
                }
            });
        });

        $(document).on('click', '.replyMessage', function () {
            let id = $(this).data('id');
            $('#reply_message_id').val(id);
            $('#replyModal').modal('show');
        });

        // ---------------- Delete Record ---------------- //
        $(document).on('click', '.deleteRecord', function () {
            let id = $(this).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: "This contact message will be deleted permanently.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#696cff',
                cancelButtonColor: '#8592a3',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('contact_messages') }}/" + id,
                        type: "DELETE",
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

        // ---------------- Bulk Delete ---------------- //
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
                title: 'Are you sure?',
                text: "Selected contact messages will be deleted permanently.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#696cff',
                cancelButtonColor: '#8592a3',
                confirmButtonText: 'Yes, delete them!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('contact_messages.bulk-delete') }}",
                        type: "DELETE",
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
                                xhr.responseJSON?.message ?? 'Something went wrong.'
                            );
                        }
                    });
                }
            });
        });

        // ---------------- Reset Bulk Delete on Draw ---------------- //
        table.on('draw', function () {
            $('#checkAll').prop('checked', false);
            $('#bulkDelete').addClass('d-none');
        });

        // ---------------- Pending Reply ---------------- //
        $(document).on('click', '.replyMessage', function () {

            let id = $(this).data('id');

            $.ajax({
                url: "{{ route('contact_messages.get-reply') }}",
                type: "GET",
                data: {
                    id: id
                },
                success: function (res) {

                    $('#replyModalTitle').text('Reply Message');
                    $('#reply_message_id').val(res.data.id);
                    $('#reply_name').val(res.data.name);
                    $('#reply_email').val(res.data.email);
                    $('#reply_subject').val(res.data.subject);
                    $('#customer_message').val(res.data.message);

                    CKEDITOR.instances.reply.setReadOnly(false);
                    CKEDITOR.instances.reply.setData('');
                    $('#sendReplyBtn').removeClass('d-none');
                    $('#sendReplyBtn').show();
                    $('#replyModal').modal('show');
                }
            });

        });


        // ---------------- Submit Reply ---------------- //
        $('#replyForm').submit(function (e) {

            e.preventDefault();

            let btn = $('#sendReplyBtn');

            btn.prop('disabled', true);

            $.ajax({

                url: "{{ route('contact_messages.send-reply') }}",

                type: "POST",

                data: {
                    id: $('#reply_message_id').val(),
                    reply: CKEDITOR.instances.reply.getData(),
                    _token: "{{ csrf_token() }}"
                },

                success: function (response) {

                    btn.prop('disabled', false);

                    $('#replyModal').modal('hide');

                    toastr.success(response.message);

                    table.ajax.reload(null, false);

                },

                error: function (xhr) {

                    btn.prop('disabled', false);

                    if (xhr.status == 422) {

                        toastr.warning(xhr.responseJSON.message);

                    } else {

                        toastr.error("Something went wrong.");

                    }

                }

            });

        });


        // ---------------- View Reply ---------------- //
        $(document).on('click', '.viewReply', function () {
            let id = $(this).data('id');

            $.ajax({
                url: "{{ route('contact_messages.view-reply') }}",
                type: "GET",
                data: {
                    id: id
                },
                success: function (res) {
                    $('#replyModalTitle').text('View Reply');
                    $('#reply_message_id').val(res.data.id);
                    $('#reply_name').val(res.data.name);
                    $('#reply_email').val(res.data.email);
                    $('#reply_subject').val(res.data.subject);
                    $('#customer_message').val(res.data.message);
                    CKEDITOR.instances.reply.setData(res.data.reply_message);
                    CKEDITOR.instances.reply.setReadOnly(true);
                    $('#sendReplyBtn').addClass('d-none');
                    $('#replyModal').modal('show');
                }
            });
        });

        // ---------------- Reset Modal ---------------- //
        $('#replyModal').on('hidden.bs.modal', function () {
            $('#sendReplyBtn').show();
            CKEDITOR.instances.reply.setReadOnly(false);
            CKEDITOR.instances.reply.setData('');
            $('#replyForm')[0].reset();
        });
    });
</script>
