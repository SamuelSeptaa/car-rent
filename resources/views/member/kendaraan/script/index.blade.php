<script>
    var date_from = "";
    var date_to = "";
    $(document).ready(function() {
        $('.daterange-cus').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('MM/DD/YYYY') + ' sd ' + picker.endDate.format(
                'MM/DD/YYYY'));

            date_from = picker.startDate.format('YYYY-MM-DD');
            date_to = picker.endDate.format('YYYY-MM-DD');
            table.ajax.reload();
        });

        $('.daterange-cus').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            date_from = "";
            date_to = "";

            table.ajax.reload();
        });

        let filterValue = [];

        var table = $("#the-data-table").DataTable({
            pageLength: 25,
            scrollX: true,
            processing: true,
            serverSide: true,
            order: [],
            ajax: {
                url: `{{ route('show-kendaraan') }}`,
                type: "POST",
                data: function(d) {
                    d.filterValue = JSON.stringify(filterValue);
                    d.search = $("#search").val();
                    d.date_from = date_from;
                    d.date_to = date_to;
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            },
            columns: [{
                    data: 'action',
                    name: 'action',
                    orderable: false,
                },
                {
                    data: 'plat_number',
                    name: 'plat_number',
                    orderable: true,
                },
                {
                    data: 'merk',
                    name: 'merk',
                    orderable: true,
                },
                {
                    data: 'model',
                    name: 'model',
                    orderable: true,
                },
                {
                    data: 'rental_rate',
                    name: 'rental_rate',
                    orderable: true,
                    className: "text-right"
                },
                {
                    data: 'color',
                    name: 'color',
                    orderable: true,
                }
            ],
            dom: "lrtip",
            createdRow: function(row, data, dataIndex) {
                $('td', row).css('vertical-align', 'middle');
            },
            // "language": {
            //     "lengthMenu": "Menampilkan _MENU_ data per halaman",
            //     "zeroRecords": "Data tidak ditemukan - maaf",
            //     "info": "Menampilkan halaman _PAGE_ dari total _PAGES_ halaman",
            //     "infoEmpty": "Tidak ada data tersedia",
            //     "infoFiltered": "(Disaring dari _MAX_ total data)"
            // }
        });

        table.on("processing.dt", function(e, settings, processing) {
            if (processing) {
                showLoading();
            } else {
                hideLoading();
            }
        });

        $('#the-data-table').on('page.dt', function() {
            $('html, body').animate({
                scrollTop: 0
            }, 500);
        });

        $("#search").keyup(
            debounce(function() {
                table.ajax.reload();
            }, 1200)
        );

        function resetFilterStatus() {
            filterValue = []
            toggleFilterStatus(".btn-filter", false)
            toggleFilterStatus(".btn-filter[data-status='all']", true)
            // table.column(10).search(JSON.stringify(filterValue))
        }

        function toggleFilterStatus(selector, status) {
            if (status) {
                $(selector).addClass("btn-info");
            } else {
                $(selector).removeClass("btn-info");
            }
        }

        $(".btn-filter").click(function(e) {
            e.preventDefault();
            let value = $(this).data('status');
            if (value == "all") {
                resetFilterStatus()
            } else {
                toggleFilterStatus(".btn-filter[data-status='all']", false)
                let filterExist = filterValue.includes(value)
                if (!filterExist) {
                    toggleFilterStatus(this, true)
                    filterValue.push(value);
                } else {
                    toggleFilterStatus(this, false)
                    let index = filterValue.indexOf(value);
                    if (index !== -1) {
                        filterValue.splice(index, 1);
                    }
                }
            }

            if (filterValue.length == 0 || filterValue.length == $('.btn-filter').length - 1) {
                resetFilterStatus();
                toggleFilterStatus(".btn-filter[data-status='all']", true)
            }
            table.ajax.reload();

            console.log(filterValue)

        });
    });
</script>
