<div class="card h-100 mb-3">
    <div class="card-body">
        <h4>Jurnal Hari Ini</h4>
        <div class="table-responsive">
            <table class="table align-middle" id="dt-newest-journals"></table>
        </div>
    </div>
</div>

@push('script')
    <script>
        $(document).ready(function() {
            const dt_journals = $('#dt-newest-journals').DataTable({
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
                    url: "{{ route('data-table.v2.data-journals') }}",
                    data: {
                        related_code: "{{ auth()->user()->profile?->code }}",
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
                        data: 'title',
                        title: "Judul Jurnal"
                    },
                    {
                        data: 'lesson.name',
                        title: 'Pelajaran'
                    },
                    {
                        title: 'Kehadiran',
                        mRender: (data, type, row) => {
                            return `<div>
                                <span class="badge bg-light-primary text-primary">${row.permit.length} Izin</span>
                                <span class="badge bg-light-warning text-warning">${row.sick.length} Sakit</span>
                                <span class="badge bg-light-danger text-danger">${row.alpha.length} Alpha</span>
                            </div>`
                        }
                    },
                    {
                        data: 'date', 
                        title: 'Tanggal',
                        render: function(data) {
                            return moment(data).format('DD MMMM YYYY')
                        }
                    }
                ]
            })
        })
    </script>
@endpush