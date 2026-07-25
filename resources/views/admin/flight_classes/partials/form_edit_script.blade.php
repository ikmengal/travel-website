<script>
    $(function(){

        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            }
        });

        if($('#description').length){
            CKEDITOR.replace('description',{
                height:250
            });
        }

        $('#name').keyup(function(){
            let slug=$(this).val()
                .toLowerCase()
                .replace(/[^a-z0-9]+/g,'-')
                .replace(/^-|-$/g,'');
            $('#slug').val(slug);
        });

        $(document).on('keyup change','input,textarea,select',function(){
            $(this).removeClass('is-invalid');
            let name=$(this).attr('name');
            $('.'+name+'_error').html('');
        });

        $('#flightClassForm').submit(function(e){
            e.preventDefault();

            for(instance in CKEDITOR.instances){
                CKEDITOR.instances[instance].updateElement();
            }

            let formData=new FormData(this);
            $('.invalid-feedback').html('');
            $('.form-control,.form-select').removeClass('is-invalid');
            $('#submitBtn')
                .prop('disabled',true)
                .html('<span class="spinner-border spinner-border-sm me-1"></span>Updating...');

            $.ajax({
                url:"{{ route('flight_classes.update',$flightClass->id) }}",
                type:"POST",
                data:formData,
                processData:false,
                contentType:false,
                success:function(response){
                    $('#submitBtn')
                        .prop('disabled',false)
                        .html('<i class="ti ti-device-floppy me-1"></i> Update Flight Class');
                    if(response.status){
                        toastr.success(response.message);
                        setTimeout(function(){
                            window.location.href="{{ route('flight_classes.index') }}";
                        },800);
                    }
                },
                error:function(xhr){
                    $('#submitBtn')
                        .prop('disabled',false)
                        .html('<i class="ti ti-device-floppy me-1"></i> Update Flight Class');
                    if(xhr.status==422){
                        $.each(xhr.responseJSON.errors,function(key,value){
                            $('[name="'+key+'"]').addClass('is-invalid');
                            $('.'+key+'_error').html(value[0]);
                        });
                    }else{
                        toastr.error('Something went wrong.');
                    }
                }
            });
        });
    });
</script>
