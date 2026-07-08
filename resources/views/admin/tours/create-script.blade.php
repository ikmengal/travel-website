<script>
    $(function () {
    // ============================= SELECT2 ============================= //
    $('.select2').select2({
        width: '100%'
    });

    // ============================= SUMMERNOTE ============================= //
    // $('#description').summernote({
    //     height: 350,
    //     placeholder: 'Write complete tour description...',
    //     toolbar: [
    //         ['style', ['style']],
    //         ['font', ['bold','italic','underline','clear']],
    //         ['fontsize', ['fontsize']],
    //         ['color', ['color']],
    //         ['para', ['ul','ol','paragraph']],
    //         ['table', ['table']],
    //         ['insert', ['link','picture','video']],
    //         ['view', ['fullscreen','codeview','help']]
    //     ]
    // });

    if (typeof CKEDITOR !== 'undefined') {
        CKEDITOR.replace('description', {
            height: 350
        });
    }

    // ============================= AUTO SLUG ============================= //
    $('#title').keyup(function(){
        let slug = $(this).val()
            .toLowerCase()
            .trim()
            .replace(/[^a-z0-9]+/g,'-')
            .replace(/^-+|-+$/g,'');

        $('#slug').val(slug);
        $('#seoPreviewTitle').text($(this).val());
        $('#seoPreviewSlug').text(slug);
    });

    // ============================= GENERATE TOUR CODE ============================= //
    $('#generateCode').click(function(){
        let random = Math.floor(1000 + Math.random() * 9000);
        $('#tour_code').val('TR-' + random);
    });

    // ============================= SHORT DESCRIPTION COUNTER ============================= //
    $('textarea[name="short_description"]').keyup(function(){
        $('#shortCount').text($(this).val().length);
    });

    // ============================= META TITLE COUNTER ============================= //
    $('#meta_title').keyup(function(){
        $('#metaTitleCount').text($(this).val().length);
        if($(this).val()!=''){
            $('#seoPreviewTitle').text($(this).val());
        }
    });

    // ============================= META DESCRIPTION COUNTER ============================= //
    $('#meta_description').keyup(function(){
        $('#metaDescriptionCount').text($(this).val().length);
        $('#seoPreviewDescription').text($(this).val());
    });

    // ============================= FEATURED IMAGE PREVIEW ============================= //
    $('#featured_image').change(function(e){
        let reader = new FileReader();
        reader.onload = function(event){
            $('#previewImage').attr('src',event.target.result);
        }
        reader.readAsDataURL(e.target.files[0]);
    });

    // ============================= LIVE PRICE PREVIEW ============================= //
    $('#price').keyup(function(){
        let value = $(this).val();
        if(value=='') value=0;
        $('#previewPrice').html('$'+parseFloat(value).toFixed(2));
        calculateDiscount();
    });

    $('#discount_price').keyup(function(){
        let value=$(this).val();
        if(value=='') value=0;
        $('#previewDiscount').html('$'+parseFloat(value).toFixed(2));
        calculateDiscount();
    });

    function calculateDiscount(){
        let price=parseFloat($('#price').val()) || 0;
        let discount=parseFloat($('#discount_price').val()) || 0;

        if(price>0 && discount>0){
            let saving=price-discount;
            let percent=(saving/price)*100;

            $('#discountAmount').text('$'+saving.toFixed(2));
            $('#discountPercent').text(percent.toFixed(1)+'%');
        }
        else{
            $('#discountAmount').text('$0.00');
            $('#discountPercent').text('0%');
        }
    }

    // ============================= DAYS PREVIEW ============================= //
    $('#duration_days').keyup(function(){
        $('#previewDays').text($(this).val());
        $('#daysPreview').text($(this).val());
    });

    // ============================= NIGHTS PREVIEW ============================= //
    $('#duration_nights').keyup(function(){
        $('#previewNights').text($(this).val());
        $('#nightsPreview').text($(this).val());
    });

    // ============================= MAX PEOPLE PREVIEW ============================= //
    $('input[name="max_people"]').keyup(function(){
        $('#previewPeople').text($(this).val());
        $('#peoplePreview').text($(this).val());
    });

    // ============================= FORM VALIDATION ============================= //
    $('form').submit(function(){
        let title=$('#title').val().trim();
        let destination=$('select[name="destination_id"]').val();
        let price=$('#price').val();
        let days=$('#duration_days').val();
        let nights=$('#duration_nights').val();

        if(title==''){
            toastr.error('Tour title is required.');
            $('#title').focus();
            return false;
        }

        if(destination==''){
            toastr.error('Please select destination.');
            return false;
        }

        if(price=='' || price<=0){
            toastr.error('Please enter valid price.');
            return false;
        }

        if(days==''){
            toastr.error('Duration days required.');
            return false;
        }

        if(nights==''){
            toastr.error('Duration nights required.');
            return false;
        }
        return true;
    });

    // ============================= RESET IMAGE ============================= //
    $('#featured_image').click(function(){
        $(this).val('');
    });

    // ============================= INITIAL COUNTERS ============================= //
    $('#shortCount').text(
        $('textarea[name="short_description"]').val().length
    );

    $('#metaTitleCount').text(
        $('#meta_title').val().length
    );

    $('#metaDescriptionCount').text(
        $('#meta_description').val().length
    );
    });
</script>
