<script>
    $(document).ready(function() {
        let filterValue = [];

        var table = $("#the-data-table").DataTable({
            pageLength: 25,
            scrollX: true,
            processing: true,
            serverSide: true,
            order: [],
            ajax: {
                url: `{{ route('show-transaksi-rental') }}`,
                type: "POST",
                data: function(d) {
                    d.filterValue = JSON.stringify(filterValue)
                    d.search = $("#search").val()
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
                    data: 'rent_start_date',
                    name: 'rent_start_date',
                    orderable: true,
                },
                {
                    data: 'rent_end_date',
                    name: 'rent_end_date',
                    orderable: true,
                },
                {
                    data: 'total_rent_fee',
                    name: 'total_rent_fee',
                    orderable: true,
                    className: "text-right"
                },
                {
                    data: 'status',
                    name: 'status',
                    orderable: true,
                    className: "text-center"
                },
                {
                    data: 'late_fee',
                    name: 'late_fee',
                    orderable: false,
                    className: "text-center"
                },
                {
                    data: 'date_of_return',
                    name: 'date_of_return',
                    orderable: true,
                },
                {
                    data: 'created_at',
                    name: 'created_at',
                    orderable: true,
                },
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
    })
</script>
