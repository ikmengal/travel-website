<script>
    $(function () {
        // ---------------- CSRF ---------------- //
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
        let table = $('#teamTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            autoWidth: false,
            ajax: {
                url: "{{ route('team_members.index') }}",
                data: function (d) {
                    d.search = $('#search').val();
                    d.status = $('#status_filter').val();
                    d.featured = $('#featured_filter').val();
                }
            },
            order: [[3,'asc']],
            columns: [
                {
                    data:'checkbox',
                    name:'checkbox',
                    orderable:false,
                    searchable:false
                },
                {
                    data:'DT_RowIndex',
                    name:'DT_RowIndex',
                    orderable:false,
                    searchable:false
                },
                {
                    data:'image',
                    name:'image',
                    orderable:false,
                    searchable:false
                },
                {
                    data:'name',
                    name:'name'
                },
                {
                    data:'designation',
                    name:'designation'
                },
                {
                    data:'social',
                    name:'social',
                    orderable:false,
                    searchable:false
                },
                {
                    data:'featured',
                    name:'featured',
                    orderable:false,
                    searchable:false
                },
                {
                    data:'status',
                    name:'status',
                    orderable:false,
                    searchable:false
                },
                {
                    data:'action',
                    name:'action',
                    orderable:false,
                    searchable:false
                }
            ]
        });

        // ---------------- Search ---------------- //
        $('#search').keyup(function () {
            table.draw();
        });

        // ---------------- Filters ---------------- //
        $('#status_filter,#featured_filter').change(function () {
            table.draw();
        });

        // ---------------- Refresh Table ---------------- //
        $('#refreshTable').click(function () {
            table.draw();
        });

        // ---------------- Reset ---------------- //
        $('#resetFilters').click(function () {
            $('#search').val('');
            $('#status_filter').val('').trigger('change');
            $('#featured_filter').val('').trigger('change');
            table.draw();
        });

        // ---------------- Check All ---------------- //
        $(document).on('change','#checkAll',function(){
            $('.row-checkbox').prop(
                'checked',
                $(this).prop('checked')
            );
            toggleBulkDelete();
        });

        $(document).on('change','.row-checkbox',function(){
            $('#checkAll').prop(
                'checked',
                $('.row-checkbox').length ==
                $('.row-checkbox:checked').length
            );
            toggleBulkDelete();
        });

        function toggleBulkDelete(){
            if($('.row-checkbox:checked').length){
                $('#bulkDeleteBtn').removeClass('d-none');
            }else{
                $('#bulkDeleteBtn').addClass('d-none');
            }
        }

        // ---------------- Bulk Delete ---------------- //
        $('#bulkDeleteBtn').click(function(){
            let ids=[];
            $('.row-checkbox:checked').each(function(){
                ids.push($(this).val());
            });
            if(ids.length==0){
                toastr.warning('Please select records.');
                return;
            }
            Swal.fire({
                title:'Delete Selected?',
                text:'Selected team members will be deleted.',
                icon:'warning',
                showCancelButton:true,
                confirmButtonText:'Delete'
            }).then((result)=>{
                if(result.isConfirmed){
                    $.post(
                        "{{ route('team_members.bulk-delete') }}",
                        {ids:ids},
                        function(response){
                            toastr.success(response.message);
                            $('#bulkDeleteBtn').addClass('d-none');
                            $('#checkAll').prop('checked',false);
                            table.ajax.reload(null,false);
                        }
                    );
                }
            });
        });

        // ---------------- Status Toggle ---------------- //
        $(document).on('change','.changeStatus',function(){
            $.post(
                "{{ route('team_members.change-status') }}",
                {
                    id:$(this).data('id'),
                    status:$(this).is(':checked') ? 1 : 0
                },
                function(response){
                    toastr.success(response.message);
                    table.ajax.reload(null,false);
                }
            );
        });

        // ---------------- Featured Toggle ---------------- //
        $(document).on('change','.changeFeatured',function(){
            $.post(
                "{{ route('team_members.change-featured') }}",
                {
                    id:$(this).data('id'),
                    featured:$(this).is(':checked') ? 1 : 0
                },
                function(response){
                    toastr.success(response.message);
                    table.ajax.reload(null,false);
                }
            );
        });

        // ---------------- Delete ---------------- //
        $(document).on('click','.deleteMember',function(){
            let url=$(this).data('url');
            Swal.fire({
                title:'Delete Team Member?',
                text:'This action cannot be undone.',
                icon:'warning',
                showCancelButton:true,
                confirmButtonText:'Delete'
            }).then((result)=>{
                if(result.isConfirmed){
                    $.ajax({
                        url:url,
                        type:'POST',
                        data:{
                            _method:'DELETE'
                        },
                        success:function(response){
                            toastr.success(response.message);
                            table.ajax.reload(null,false);
                        },
                        error:function(xhr){
                            toastr.error(
                                xhr.responseJSON.message ??
                                'Something went wrong.'
                            );
                        }
                    });
                }
            });
        });
    });
</script>
