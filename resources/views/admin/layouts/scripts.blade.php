<script src="{{ asset('admin/assets/vendor/libs/jquery/jquery.js') }}"></script>
<script src="{{ asset('admin/assets/vendor/libs/popper/popper.js') }}"></script>
<script src="{{ asset('admin/assets/vendor/js/bootstrap.js') }}"></script>
<script src="{{ asset('admin/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
<script src="{{ asset('admin/assets/vendor/libs/node-waves/node-waves.js') }}"></script>

<script src="{{ asset('admin/assets/vendor/libs/hammer/hammer.js') }}"></script>
<script src="{{ asset('admin/assets/vendor/libs/i18n/i18n.js') }}"></script>
<script src="{{ asset('admin/assets/vendor/libs/typeahead-js/typeahead.js') }}"></script>

<script src="{{ asset('admin/assets/vendor/js/menu.js') }}"></script>
<!-- endbuild -->

<!-- Vendors JS -->
<script src="{{ asset('admin/assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
<script src="{{ asset('admin/assets/vendor/libs/swiper/swiper.js') }}"></script>
<script src="{{ asset('admin/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
<script src="{{ asset('admin/assets/vendor/js/ext-component-sweet-alerts.min.js') }}"></script>
<script src="{{ asset('admin/assets/vendor/js/sweetalert211.js') }}"></script>
<script src="{{ asset('admin/assets/vendor/js/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('admin/assets/js/fancy-box.js') }}"></script>
<!-- Main JS -->
<script src="{{ asset('admin/assets/js/main.js') }}"></script>
<script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>
<script src="{{ asset('admin/assets/js/select2.min.js') }}"></script>
<script src="{{ asset('admin/assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
<script src="{{ asset('admin/assets/vendor/libs/tagify/tagify.js') }}"></script>
<!-- Page JS -->
<script src="{{ asset('admin/assets/js/toastr.min.js') }}"></script>
<script src="{{ asset('admin/assets/js/action-gateway.js?v=1.0.14') }}"></script>
<script src="{{ asset('admin/assets/js/pages-profile.js') }}"></script>
@stack('js')
<script>
    function showFancyBox() {
        $.fancybox.open('<div class="fancybox-loading"></div>', {
            closeExisting: true,
            toolbar: false,
            smallBtn: false,
            modal: false,
            keyboard: false,
            clickSlide: false,
            touch: false,
            caption: 'Please wait while your request is being processed.'
        });
    }

    function hideFancyBox() {
        $.fancybox.close();
    }

    $('.form-select').each(function() {
        $(this).select2({
            dropdownParent: $(this).parent(),
        });
    });

    if (typeof description !== 'undefined') {
        CKEDITOR.replace('description');
    }

    if ('serviceWorker' in navigator) {
            window.addEventListener('load', function () {
                navigator.serviceWorker.register('/sw.js')
                .then(function(registration){
                console.log("Service Worker Registered");
            })
            .catch(function(error){
                console.log(error);
            });
        });
    }
</script>
