<script>
    $(function () {
        // -------------- CSRF -------------- //
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // -------------- Select2 -------------- //
        $('.select2').select2({
            width: '100%'
        });

        // -------------- DataTable -------------- //
        let table = $('#airlinesTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            autoWidth: false,
            ordering: true,
            searching: false,
            pageLength: 10,
            lengthMenu: [
                [10,25,50,100],
                [10,25,50,100]
            ],

            ajax: {
                url: "{{ route('airlines.index') }}",
                data: function (d) {
                    d.search    = $('#search').val();
                    d.status    = $('#status_filter').val();
                    d.featured  = $('#featured_filter').val();
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
                    data: 'iata_code',
                    name: 'iata_code'
                },
                {
                    data: 'icao_code',
                    name: 'icao_code'
                },
                {
                    data: 'airline_code',
                    name: 'airline_code'
                },
                {
                    data: 'website',
                    name: 'website'
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

        // -------------- Live Search -------------- //
        let typingTimer;
        $('#search').keyup(function () {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(function () {
                table.ajax.reload();
            },400);
        });

        // -------------- Filters -------------- //
        $('#status_filter,#featured_filter').change(function(){
            table.ajax.reload();
        });

        // -------------- Reset Filters -------------- //
        $('#resetFilters').click(function(){
            $('#search').val('');
            $('#status_filter').val('').trigger('change');
            $('#featured_filter').val('').trigger('change');
            table.ajax.reload();
        });

        // -------------- Check All  -------------- //
        $(document).on('change','#checkAll',function(){
            $('.recordCheckbox').prop('checked',$(this).prop('checked'));
            toggleBulkDelete();
        });

        $(document).on('change','.recordCheckbox',function(){
            $('#checkAll').prop('checked',
                $('.recordCheckbox').length ==
                $('.recordCheckbox:checked').length
            );
            toggleBulkDelete();
        });

        function toggleBulkDelete(){
            if($('.recordCheckbox:checked').length){
                $('#bulkDeleteBtn').show();
            }else{
                $('#bulkDeleteBtn').hide();
            }
        }

        // -------------- Bulk Delete -------------- //
        $('#bulkDeleteBtn').click(function(){
            let ids=[];
            $('.recordCheckbox:checked').each(function(){
                ids.push($(this).val());
            });

            if(ids.length==0){
                toastr.warning('Please select at least one airline.');
                return;
            }

            Swal.fire({
                title:'Delete Selected?',
                text:'Selected airlines will be deleted.',
                icon:'warning',
                showCancelButton:true,
                confirmButtonColor:'#d33',
                confirmButtonText:'Yes Delete'
            }).then((result)=>{
                if(result.isConfirmed){
                    $.ajax({
                        url:"{{ route('airlines.bulk-delete') }}",
                        type:'POST',
                        data:{
                            ids:ids
                        },
                        success:function(res){
                            toastr.success(res.message);
                            $('#checkAll').prop('checked',false);
                            $('#bulkDeleteBtn').hide();
                            table.ajax.reload(null,false);
                        },
                        error:function(xhr){
                            toastr.error(xhr.responseJSON.message);
                        }
                    });
                }
            });
        });

        // -------------- Delete Record -------------- //
        $(document).on('click','.deleteRecord',function(){
            let url=$(this).data('url');
            Swal.fire({
                title:'Delete Airline?',
                text:'This action cannot be undone.',
                icon:'warning',
                showCancelButton:true,
                confirmButtonColor:'#d33',
                confirmButtonText:'Delete'
            }).then((result)=>{
                if(result.isConfirmed){
                    $.ajax({
                        url:url,
                        type:'DELETE',
                        success:function(res){
                            toastr.success(res.message);
                            table.ajax.reload(null,false);
                        },
                        error:function(xhr){
                            toastr.error(xhr.responseJSON.message);
                        }
                    });
                }
            });
        });

        // -------------- Status Change -------------- //
        $(document).on('change','.changeStatus',function(){
            let id=$(this).data('id');
            let status=$(this).prop('checked') ? 1 : 0;
            $.ajax({
                url:"{{ route('airlines.change-status') }}",
                type:'POST',
                data:{
                    id:id,
                    status:status
                },
                success:function(res){
                    toastr.success(res.message);
                },
                error:function(){
                    toastr.error('Something went wrong.');
                }
            });
        });

        // -------------- Featured Change -------------- //
        $(document).on('change','.changeFeatured',function(){
            let id=$(this).data('id');
            let featured=$(this).prop('checked') ? 1 : 0;

            $.ajax({
                url:"{{ route('airlines.change-featured') }}",
                type:'POST',
                data:{
                    id:id,
                    featured:featured
                },
                success:function(res){
                    toastr.success(res.message);
                },
                error:function(){
                    toastr.error('Something went wrong.');
                }
            });
        });
    });
</script>
