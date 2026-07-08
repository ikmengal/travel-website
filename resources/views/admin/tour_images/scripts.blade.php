<script>
    const csrfToken = "{{ csrf_token() }}";
    const tourImageIndexUrl = "{{ route('tour_images.index') }}";
    const changeStatusUrl = "{{ route('tour_images.change-status') }}";
    const bulkDeleteUrl = "{{ route('tour_images.bulk-delete') }}";
</script>
<script>
    $(function () {
        // ==========================================================
        // SELECT2
        // ==========================================================
        $('.select2').select2({
            width: '100%'
        });

        // ==========================================================
        // DATATABLE
        // ==========================================================
        let table = $('#tourImageTable').DataTable({

            processing: true,

            serverSide: true,

            responsive: true,

            autoWidth: false,

            pageLength: 25,

            order: [[7, 'desc']],

            ajax: {

                url: tourImageIndexUrl,

                data: function (d) {

                    d.loaddata = "yes";

                    d.tour = $('#tour_filter').val();

                    d.status = $('#status_filter').val();

                    d.search = $('#search').val();

                }

            },

            columns: [

                {
                    data: 'checkbox',
                    orderable: false,
                    searchable: false
                },

                {
                    data: 'image',
                    orderable: false,
                    searchable: false
                },

                {
                    data: 'tour',
                    name: 'tour.title'
                },

                {
                    data: 'title',
                    name: 'title'
                },

                {
                    data: 'caption',
                    name: 'caption'
                },

                {
                    data: 'sort_order',
                    name: 'sort_order'
                },

                {
                    data: 'status',
                    orderable: false,
                    searchable: false
                },

                {
                    data: 'created_at',
                    name: 'created_at'
                },

                {
                    data: 'action',
                    orderable: false,
                    searchable: false
                }

            ]

        });

        // ==========================================================
        // FILTERS
        // ==========================================================
        $('#tour_filter').change(function(){

            table.draw();

        });

        $('#status_filter').change(function(){

            table.draw();

        });

        $('#search').keyup(function(){

            table.draw();

        });

        // ==========================================================
        // REFRESH
        // ==========================================================
        $('#refreshTable').click(function(){

            table.ajax.reload(null,false);

        });

        // ==========================================================
        // CHECK ALL
        // ==========================================================
        $(document).on('change','#checkAll',function(){

            $('.row-checkbox').prop('checked',$(this).is(':checked'));

            toggleBulkDelete();

        });

        $(document).on('change','.row-checkbox',function(){

            toggleBulkDelete();

            if(!$(this).is(':checked')){

                $('#checkAll').prop('checked',false);

            }

        });

        function toggleBulkDelete(){

            let total = $('.row-checkbox:checked').length;

            if(total > 0){

                $('#bulkDelete').removeClass('d-none');

            }else{

                $('#bulkDelete').addClass('d-none');

            }

        }

        // ==========================================================
        // BULK DELETE
        // ==========================================================
        $(document).on('click','#bulkDelete',function(){
            let ids = [];

            $('.row-checkbox:checked').each(function(){

                ids.push($(this).val());

            });

            if(ids.length == 0){

                return;

            }

            Swal.fire({
                title:'Delete Selected Images?',
                text:'This action cannot be undone.',
                icon:'warning',
                showCancelButton:true,
                confirmButtonColor:'#d33',
                confirmButtonText:'Delete'
            }).then((result)=>{
                if(!result.isConfirmed){
                    return;
                }
                $.ajax({
                    url: bulkDeleteUrl,
                    type:'POST',
                    data:{
                        _token: csrfToken,
                        ids: ids
                    },
                    success:function(response){
                        toastr.success(response.message);
                        table.ajax.reload(null,false);
                        $('#bulkDelete').addClass('d-none');
                        $('#checkAll').prop('checked',false);
                    },
                    error:function(){
                        toastr.error('Delete failed.');
                    }
                });
            });
        });

        // ==========================================================
        // STATUS TOGGLE
        // ==========================================================
        $(document).on('change','.changeStatus',function(){
            let id = $(this).data('id');

            $.ajax({
                url: changeStatusUrl,
                type:'POST',
                data:{
                    _token: csrfToken,
                    id:id
                },
                success:function(response){
                    toastr.success(response.message);
                    table.ajax.reload(null,false);
                },
                error:function(){
                    toastr.error('Status update failed.');
                    table.ajax.reload(null,false);
                }
            });
        });

        // ==========================================================
        // SINGLE DELETE
        // ==========================================================
        $(document).on('click','.deleteRecord',function(e){
            e.preventDefault();
            let url = $(this).data('url');

            Swal.fire({
                title:'Delete Image?',
                text:'This action cannot be undone.',
                icon:'warning',
                showCancelButton:true,
                confirmButtonColor:'#d33',
                confirmButtonText:'Delete'
            }).then((result)=>{
                if(!result.isConfirmed){
                    return;
                }
                $.ajax({
                    url:url,
                    type:'DELETE',
                    data:{
                        _token: csrfToken
                    },
                    success:function(response){
                        toastr.success(response.message);
                        table.ajax.reload(null,false);
                    },
                    error:function(){
                        toastr.error('Delete failed.');
                    }
                });
            });
        });
    });
</script>
