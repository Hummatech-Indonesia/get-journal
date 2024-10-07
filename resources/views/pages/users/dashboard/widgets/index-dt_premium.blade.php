<div class="card h-100">
    <div class="card-body">
        <h4>Premium</h4>
        <div class="table-responsive">
            <table class="table align-middle" id="dt-premiums"></table>
        </div>
    </div>
</div>

@push('script')
    <script>
        $(document).ready(function() {
            const dt_premiums = $('#dt-premiums').DataTable({
                language: {
                    processing: 'memuat...'
                },
                processing: true,
                serverSide: true,
                lengthMenu: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, 'Semua']
                ],
                dom: "rt",
                order: [
                    [3, 'desc']
                ],
                initComplete: function() {
                    $('.dt-buttons').addClass('btn-group-sm')
                },
                ajax: {
                    url: "{{ route('data-table.data-quota-premium') }}",
                    data: {
                        user_id: "{{ auth()->id() }}",
                    }
                },
                columns: [
                    {
                        data: "DT_RowIndex",
                        title: '#',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'created_at',
                        title: "Tanggal Pembelian",
                        orderable: false
                    },
                    {
                        data: 'time',
                        title: 'Durasi',
                        render: (data) => {
                            return data+' bulan'
                        },
                        orderable: false
                    },
                    {
                        data: 'expired_date',
                        title: 'Tanggal Kedaluwarsa',
                        render: (data, type, row) => {
                            return moment(data),locale('id').format('DD MMMM YYYY')
                        }
                    },
                    {
                        title: 'Dibeli',
                        data: 'quantity',
                        orderable: false
                    }, {
                        title: 'Digunakan',
                        data: 'used_quantity',
                        orderable: false
                    }
                ]
            })
        })
    </script>
@endpush