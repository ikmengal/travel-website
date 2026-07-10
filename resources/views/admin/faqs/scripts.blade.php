<script>
    $(function () {
        // ----------- SELECT2 ----------- //
        $('.select2').select2({
            width: '100%'
        });

        // ----------- DATATABLE ----------- //
        let table = $('#faqTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: false,
            autoWidth: false,
            pageLength: 25,
            order: [[9, 'desc']],

            ajax: {
                url: "{{ route('faqs.index') }}",
                data: function (d) {
                    d.loaddata = "yes";
                    d.faqable_type = $('#faq_type_filter').val();
                    d.faqable_id = $('#related_item_filter').val();
                    d.status = $('#status_filter').val();
                    d.featured = $('#featured_filter').val();
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
                    data: 'type',
                    name: 'faqable_type'
                },
                {
                    data: 'related',
                    name: 'faqable_id'
                },
                {
                    data: 'question',
                    name: 'question'
                },
                {
                    data: 'answer',
                    name: 'answer'
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
                    data: 'sort_order',
                    name: 'sort_order'
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

        // ----------- FILTERS ----------- //
        $('#faq_type_filter').change(function () {
            loadRelatedItems($(this).val());
            table.draw();
        });

        $('#related_item_filter').change(function () {
            table.draw();
        });

        $('#status_filter').change(function () {
            table.draw();
        });

        $('#featured_filter').change(function () {
            table.draw();
        });

        $('#search').keyup(function () {
            table.draw();
        });

        // ----------- LOAD RELATED ITEMS ----------- //
        function loadRelatedItems(type)
        {
            $('#related_item_filter').html('<option value="">Loading...</option>');
            $.ajax({
                url: "{{ route('faqs.get-models') }}",
                type: "GET",
                data: {
                    type: type
                },
                success:function(response){
                    let html = '<option value="">All</option>';
                    $.each(response,function(index,item){
                        html += '<option value="'+item.id+'">'+item.title+'</option>';
                    });
                    $('#related_item_filter').html(html);
                }
            });
        }

        // ----------- REFRESH ----------- //
        $('#refreshTable').click(function(){
            table.ajax.reload();
        });

        // ----------- CHECK ALL ----------- //
        $(document).on('change','#checkAll',function(){
            $('.row-checkbox').prop('checked',$(this).is(':checked'));
            toggleBulk();
        });

        $(document).on('change','.row-checkbox',function(){
            toggleBulk();
        });

        function toggleBulk()
        {
            if($('.row-checkbox:checked').length > 0){
                $('#bulkDelete').removeClass('d-none');
            }else{
                $('#bulkDelete').addClass('d-none');
            }
        }

        // ----------- STATUS ----------- //
        $(document).on('change','.changeStatus',function(){
            $.ajax({
                url:"{{ route('faqs.change-status') }}",
                type:"POST",
                data:{
                    _token:"{{ csrf_token() }}",
                    id:$(this).data('id')
                },
                success:function(res){
                    toastr.success(res.message);
                    table.ajax.reload(null,false);
                }
            });
        });

        // ----------- FEATURED ----------- //
        $(document).on('change','.changeFeatured',function(){
            $.ajax({
                url:"{{ route('faqs.change-featured') }}",
                type:"POST",
                data:{
                    _token:"{{ csrf_token() }}",
                    id:$(this).data('id')
                },
                success:function(res){
                    toastr.success(res.message);
                    table.ajax.reload(null,false);
                }
            });
        });

        // ----------- DELETE ----------- //
        $(document).on('click','.deleteRecord',function(){
            let url=$(this).data('url');

            Swal.fire({
                title:'Delete FAQ?',
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
                        data:{
                            _token:"{{ csrf_token() }}"
                        },
                        success:function(res){
                            toastr.success(res.message);
                            table.ajax.reload(null,false);
                        }
                    });
                }
            });
        });

        // ----------- BULK DELETE ----------- //
        $('#bulkDelete').click(function(){
            let ids=[];

            $('.row-checkbox:checked').each(function(){
                ids.push($(this).val());
            });

            if(ids.length==0){
                toastr.error('Please select records.');
                return;
            }

            Swal.fire({
                title:'Delete Selected FAQs?',
                icon:'warning',
                showCancelButton:true,
                confirmButtonColor:'#d33',
                confirmButtonText:'Delete'
            }).then((result)=>{
                if(result.isConfirmed){
                    $.ajax({
                        url:"{{ route('faqs.bulk-delete') }}",
                        type:"POST",
                        data:{
                            _token:"{{ csrf_token() }}",
                            ids:ids
                        },
                        success:function(res){
                            toastr.success(res.message);
                            table.ajax.reload(null,false);
                            $('#checkAll').prop('checked',false);
                            $('#bulkDelete').addClass('d-none');
                        }
                    });
                }
            });
        });
    });
</script>
