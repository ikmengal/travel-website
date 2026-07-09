<script>
    $(function(){
        $('.select2').select2({
            width:'100%'
        });

        $('#icon').on('keyup change',function(){
            let icon=$(this).val().trim();
            if(icon==''){
                icon='ti ti-home';
            }
            $('#iconPreview').html('<i class="'+icon+'"></i>');
        });

        $(document).on('click','.icon-item',function(){
            let icon=$(this).data('icon');
            $('#icon').val(icon).trigger('keyup');
        });
    });
</script>
