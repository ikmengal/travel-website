<script>
    $(function () {
        let table = $('.destinationTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: false,
            autoWidth: false,
            order: [[1, 'asc']],
            ajax: {
                url: "{{ route('tour_categories.index') }}",
                data: function (d) {
                    d.loaddata = "yes";
                }
            },
            columns: [
                {
                    data:'checkbox',
                    name:'checkbox',
                    orderable:false,
                    searchable:false
                },
                {
                    data:'DT_RowIndex',
                    name:'DT_RowIndex',
                    searchable:false,
                    orderable:false
                },
                {
                    data:'icon',
                    name:'icon',
                    searchable:false,
                    orderable:false
                },

                {
                    data:'status',
                    name:'status'
                },

                {
                    data:'created_at',
                    name:'created_at'
                },

                {
                    data:'action',
                    name:'action',
                    searchable:false,
                    orderable:false
                }
            ]
        });

        // --------------------- Check All --------------------- //
        $(document).on('change', '#checkAll', function () {
            $('.row-checkbox').prop('checked', $(this).is(':checked'));
        });
    });
</script>
