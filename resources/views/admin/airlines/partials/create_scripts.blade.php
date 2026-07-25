
<script>
$(function () {

    // =====================================================
    // CSRF
    // =====================================================

    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
        }
    });

    // =====================================================
    // Select2
    // =====================================================

    $('.select2').select2({
        width:'100%'
    });

    // =====================================================
    // CKEditor 4
    // =====================================================

    if ($('#description').length) {

        CKEDITOR.replace('description',{
            height:350
        });

    }

    // =====================================================
    // Auto Slug
    // =====================================================

    $('#name').on('keyup',function(){

        let slug = $(this).val()
            .toLowerCase()
            .trim()
            .replace(/[^a-z0-9]+/g,'-')
            .replace(/^-|-$/g,'');

        $('#slug').val(slug);

    });

    // =====================================================
    // Logo Preview
    // =====================================================

    $('#logo').change(function(){

        let reader = new FileReader();

        reader.onload=function(e){

            $('#logoPreview').attr('src',e.target.result);

        }

        if(this.files.length){

            reader.readAsDataURL(this.files[0]);

        }

    });

    // =====================================================
    // Submit
    // =====================================================

    $('#airlineForm').submit(function(e){

        e.preventDefault();

        for(instance in CKEDITOR.instances){

            CKEDITOR.instances[instance].updateElement();

        }

        let form = this;

        let formData = new FormData(form);

        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').html('');

        let isEdit = "{{ isset($airline) ? 1 : 0 }}";

        let url = isEdit
            ? "{{ isset($airline) ? route('airlines.update',$airline->id) : '' }}"
            : "{{ route('airlines.store') }}";

        $('#submitBtn')
            .prop('disabled',true)
            .html('<span class="spinner-border spinner-border-sm me-2"></span>Please Wait...');

        $.ajax({

            url:url,

            type:'POST',

            data:formData,

            processData:false,

            contentType:false,

            cache:false,

            success:function(response){

                toastr.success(response.message);

                setTimeout(function(){

                    window.location.href="{{ route('airlines.index') }}";

                },700);

            },

            error:function(xhr){

                if(xhr.status===422){

                    $.each(xhr.responseJSON.errors,function(key,value){

                        $('[name="'+key+'"]')
                            .addClass('is-invalid');

                        $('.'+key+'_error')
                            .html(value[0]);

                    });

                }
                else{

                    toastr.error(xhr.responseJSON.message);

                }

            },

            complete:function(){

                $('#submitBtn')
                    .prop('disabled',false)
                    .html('<i class="ti ti-device-floppy me-1"></i> {{ isset($airline) ? "Update Airline" : "Save Airline" }}');

            }

        });

    });

});
</script>
