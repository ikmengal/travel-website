<script>
    $(function () {
        // -------------- SELECT2 -------------- //
        $('.select2').select2({
            width: '100%'
        });

        // -------------- DATATABLE -------------- //
        let table = $('#tourItineraryTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: false,
            autoWidth: false,
            pageLength: 25,
            order: [[6,'desc']],

            ajax: {
                url: "{{ route('tour_itineraries.index') }}",
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
                    data: 'day',
                    name: 'day'
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
                    data: 'description',
                    name: 'description'
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

        // -------------- FILTERS -------------- //
        $('#tour_filter').change(function(){
            table.draw();
        });

        $('#status_filter').change(function(){
            table.draw();
        });

        $('#search').keyup(function(){
            table.draw();
        });

        // -------------- REFRESH -------------- //
        $('#refreshTable').click(function(){
            table.ajax.reload(null,false);
        });

        // -------------- CHECK ALL -------------- //
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

        // -------------- BULK DELETE -------------- //
        $(document).on('click','#bulkDelete',function(){
            let ids = [];

            $('.row-checkbox:checked').each(function(){
                ids.push($(this).val());
            });

            if(ids.length == 0){
                return;
            }

            Swal.fire({
                title: 'Delete Selected Itineraries?',
                text: 'This action cannot be undone.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#8592a3',
                confirmButtonText: 'Delete'
            }).then((result)=>{
                if(!result.isConfirmed){
                    return;
                }
                $.ajax({
                    url: "{{ route('tour_itineraries.bulk-delete') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        ids: ids
                    },
                    success:function(response){
                        toastr.success(response.message);
                        table.ajax.reload(null,false);
                        $('#bulkDelete').addClass('d-none');
                        $('#checkAll').prop('checked',false);
                    },
                    error:function(){
                        toastr.error("Delete failed.");
                    }
                });
            });
        });

        // -------------- STATUS -------------- //
        $(document).on('change','.changeStatus',function(){
            let id = $(this).data('id');

            $.ajax({
                url: "{{ route('tour_itineraries.change-status') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    id:id
                },
                success:function(response){
                    toastr.success(response.message);
                    table.ajax.reload(null,false);
                },
                error:function(){
                    toastr.error("Status update failed.");
                    table.ajax.reload(null,false);
                }
            });
        });

        // -------------- SINGLE DELETE -------------- //
        $(document).on('click','.deleteRecord',function(e){
            e.preventDefault();
            let url = $(this).data('url');

            Swal.fire({
                title:'Delete Itinerary?',
                text:'This action cannot be undone.',
                icon:'warning',
                showCancelButton:true,
                confirmButtonColor:'#d33',
                cancelButtonColor:'#8592a3',
                confirmButtonText:'Delete'
            }).then((result)=>{
                if(!result.isConfirmed){
                    return;
                }
                $.ajax({
                    url:url,
                    type:'DELETE',
                    data:{
                        _token:"{{ csrf_token() }}"
                    },
                    success:function(response){
                        toastr.success(response.message);
                        table.ajax.reload(null,false);
                    },
                    error:function(){
                        toastr.error("Delete failed.");
                    }
                });
            });
        });
    });
</script>
