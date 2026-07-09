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

    let table = $('#tourIncludeTable').DataTable({

        processing: true,

        serverSide: true,

        responsive: false,

        autoWidth: false,

        pageLength: 25,

        order: [[6,'desc']],

        ajax: {

            url: "{{ route('tour_includes.index') }}",

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
                name: 'checkbox',
                orderable: false,
                searchable: false
            },

            {
                data: 'tour',
                name: 'tour.title'
            },

            {
                data: 'icon',
                name: 'icon',
                orderable: false,
                searchable: false
            },

            {
                data: 'title',
                name: 'title'
            },

            {
                data: 'sort_order',
                name: 'sort_order'
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

            title:'Delete Selected Includes?',

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

                url:"{{ route('tour_includes.bulk-delete') }}",

                type:"POST",

                data:{

                    _token:"{{ csrf_token() }}",

                    ids:ids

                },

                success:function(response){

                    toastr.success(response.message);

                    table.ajax.reload(null,false);

                    $('#checkAll').prop('checked',false);

                    $('#bulkDelete').addClass('d-none');

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

        let id=$(this).data('id');

        $.ajax({

            url:"{{ route('tour_includes.change-status') }}",

            type:"POST",

            data:{

                _token:"{{ csrf_token() }}",

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
    // DELETE
    // ==========================================================

    $(document).on('click','.deleteRecord',function(e){

        e.preventDefault();

        let url=$(this).data('url');

        Swal.fire({

            title:'Delete Include?',

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

                type:"DELETE",

                data:{

                    _token:"{{ csrf_token() }}"

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

    // ==========================================================
    // ICON PREVIEW
    // ==========================================================

    $('#icon').keyup(function(){

        let icon = $(this).val().trim();

        if(icon == ''){

            icon = 'ti ti-home';

        }

        $('#iconPreview').html('<i class="'+icon+'"></i>');

    });

    // ==========================================================
    // ICON PICKER
    // ==========================================================

    $(document).on('click','.icon-item',function(){

        let icon = $(this).data('icon');

        $('#icon').val(icon);

        $('#iconPreview').html('<i class="'+icon+'"></i>');

    });

});

</script>
