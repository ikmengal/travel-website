<script>
    $(function () {
        $('.select2').select2({
            width: '100%'
        });

        function updateSummary() {
            let departure = $('input[name="departure_date"]').val();
            let returning = $('input[name="return_date"]').val();
            let seats = $('input[name="available_seats"]').val();

            $('#departurePreview').text(
                departure !== '' ? departure : '--'
            );

            $('#returnPreview').text(
                returning !== '' ? returning : '--'
            );

            $('#seatPreview').text(
                seats !== '' ? seats : 0
            );
        }

        $('input[name="departure_date"]').on('change', updateSummary);
        $('input[name="return_date"]').on('change', updateSummary);
        $('input[name="available_seats"]').on('keyup change', updateSummary);
        updateSummary();
    });
</script>
