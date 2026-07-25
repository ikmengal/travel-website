<script>
    $(function () {

        // ==============================
        // CSRF
        // ==============================
        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            }
        });

        // ==============================
        // Select2
        // ==============================
        $('.select2').select2({
            width:'100%'
        });

        // ==============================
        // DataTable
        // ==============================
        let table = $('#flightClassTable').DataTable({

            processing:true,

            serverSide:true,

            responsive:true,

            autoWidth:false,

            order:[[1,'desc']],

            ajax:{
                url:"{{ route('flight_classes.index') }}",

                data:function(d){

                    d.search       = $('#search').val();
                    d.status       = $('#status_filter').val();
                    d.meal         = $('#meal_filter').val();
                    d.refundable   = $('#refundable_filter').val();

                }
            },

            columns:[

                {
                    data:'checkbox',
                    name:'checkbox',
                    orderable:false,
                    searchable:false
                },

                {
                    data:'DT_RowIndex',
                    name:'DT_RowIndex',
                    searchable:false,
                    orderable:false
                },

                {
                    data:'name',
                    name:'name'
                },

                {
                    data:'baggage',
                    name:'baggage'
                },

                {
                    data:'seat_priority',
                    name:'seat_priority'
                },

                {
                    data:'meal',
                    name:'meal'
                },

                {
                    data:'refundable',
                    name:'refundable'
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

            ],

            drawCallback:function(){

                $('#checkAll').prop('checked',false);

                toggleBulkDelete();

            }

        });

        // ==============================
        // Filters
        // ==============================
        $('#search').keyup(function(){

            table.draw();

        });

        $('#status_filter').change(function(){

            table.draw();

        });

        $('#meal_filter').change(function(){

            table.draw();

        });

        $('#refundable_filter').change(function(){

            table.draw();

        });

        // ==============================
        // Reset Filters
        // ==============================
        $('#resetFilter').click(function(){

            $('#search').val('');

            $('#status_filter').val('').trigger('change');

            $('#meal_filter').val('').trigger('change');

            $('#refundable_filter').val('').trigger('change');

            table.draw();

        });

        // ==============================
        // Select All
        // ==============================
        $(document).on('change','#checkAll',function(){

            $('.checkSingle').prop('checked',$(this).prop('checked'));

            toggleBulkDelete();

        });

        // ==============================
        // Single Checkbox
        // ==============================
        $(document).on('change','.checkSingle',function(){

            toggleBulkDelete();

        });

        function toggleBulkDelete(){

            let total = $('.checkSingle:checked').length;

            if(total>0){

                $('#bulkDeleteBtn').removeClass('d-none');

            }else{

                $('#bulkDeleteBtn').addClass('d-none');

            }

        }

            // ==============================
        // Change Status
        // ==============================
        $(document).on('change','.changeStatus',function(){

            let id = $(this).data('id');

            let status = $(this).prop('checked') ? 1 : 0;

            $.ajax({

                url:"{{ route('flight_classes.change-status') }}",

                type:"POST",

                data:{
                    id:id,
                    status:status
                },

                success:function(response){

                    if(response.status){

                        toastr.success(response.message);

                    }else{

                        toastr.error(response.message);

                        table.ajax.reload(null,false);

                    }

                },

                error:function(){

                    toastr.error('Something went wrong.');

                    table.ajax.reload(null,false);

                }

            });

        });

        // ==============================
        // Delete Record
        // ==============================
        $(document).on('click','.deleteRecord',function(){

            let url = $(this).data('url');

            Swal.fire({

                title:'Are you sure?',

                text:'You will not be able to recover this record.',

                icon:'warning',

                showCancelButton:true,

                confirmButtonColor:'#7367f0',

                cancelButtonColor:'#ea5455',

                confirmButtonText:'Yes, Delete'

            }).then((result)=>{

                if(result.isConfirmed){

                    $.ajax({

                        url:url,

                        type:'DELETE',

                        success:function(response){

                            if(response.status){

                                toastr.success(response.message);

                                table.ajax.reload(null,false);

                            }else{

                                toastr.error(response.message);

                            }

                        },

                        error:function(){

                            toastr.error('Something went wrong.');

                        }

                    });

                }

            });

        });

        // ==============================
        // Bulk Delete
        // ==============================
        $('#bulkDeleteBtn').click(function(){

            let ids=[];

            $('.checkSingle:checked').each(function(){

                ids.push($(this).val());

            });

            if(ids.length==0){

                toastr.warning('Please select at least one record.');

                return;

            }

            Swal.fire({

                title:'Delete Selected?',

                text:'Selected records will be deleted permanently.',

                icon:'warning',

                showCancelButton:true,

                confirmButtonColor:'#7367f0',

                cancelButtonColor:'#ea5455',

                confirmButtonText:'Delete'

            }).then((result)=>{

                if(result.isConfirmed){

                    $.ajax({

                        url:"{{ route('flight_classes.bulk-delete') }}",

                        type:"POST",

                        data:{
                            ids:ids
                        },

                        success:function(response){

                            if(response.status){

                                toastr.success(response.message);

                            }else{

                                toastr.error(response.message);

                            }

                            $('#checkAll').prop('checked',false);

                            $('#bulkDeleteBtn').addClass('d-none');

                            table.ajax.reload();

                        },

                        error:function(){

                            toastr.error('Something went wrong.');

                        }

                    });

                }

            });

        });

    });
</script>
