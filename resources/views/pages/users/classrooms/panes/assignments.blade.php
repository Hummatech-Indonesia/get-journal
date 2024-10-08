<div class="card">
    <div class="card-body table-responsive">
        <div class="alert alert-warning" role="alert">
            Jika ingin melakukan cetak data, pastikan kolom "entries per page" bernilai "semua"
        </div>
        <table class="table align-middle" id="dt-assignments"></table>
    </div>
</div>

<div class="modal fade" id="modal-detail" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Jurnal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex flex-column gap-3">
                    <div class="p-3 rounded bg-light-dark text-dark">
                        <h6 class="text-dark">Deskripsi</h6>
                        <p id="description"></p>
                    </div>
                    <div class="p-3 rounded bg-light-primary text-primary">
                        <h6 class="text-primary">Izin</h6>
                        <p id="permit"></p>
                    </div>
                    <div class="p-3 rounded bg-light-warning text-warning">
                        <h6 class="text-warning">Sakit</h6>
                        <p id="sick"></p>
                    </div>
                    <div class="p-3 rounded bg-light-danger text-danger">
                        <h6 class="text-danger">Alpha</h6>
                        <p id="alpha"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-download-journal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Download Jurnal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="form-group mb-3">
                    <label for="filename" class="form-label">Nama File</label>
                    <input type="text" class="form-control" id="filename" placeholder="Nama File" required>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group mb-3">
                            <label for="start_date" class="form-label">Tanggal Awal</label>
                            <input type="date" class="form-control" id="start_date" value="{{ date('Y-m-d') }}" required>
                        </div>
                    </div>
                    <div class="col-1">
                        -
                    </div>
                    <div class="col">
                        <div class="form-group mb-3">
                            <label for="end_date" class="form-label">Tanggal Akhir</label>
                            <input type="date" class="form-control" id="end_date" value="{{ date('Y-m-d') }}" required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" id="btn-submit-download-journal" class="btn btn-success">Cetak</button>
            </div>
        </div>
    </div>
</div>

@push('script')
    <script>
        $(document).ready(function() {
            const dt_assignments = $('#dt-assignments').DataTable({
                language: {
                    processing: 'memuat...'
                },
                processing: true,
                serverSide: true,
                lengthMenu: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, 'Semua']
                ],
                dom: "<'row mt-2 justify-content-between'<'col-sm-auto me-auto'B><'col-auto ms-auto custom-container-assignment'>><'row mt-2 justify-content-between'<'col-sm-auto me-auto'l><'col-sm-auto me-start'f>><'row mt-2 justify-content-md-center'<'col-12'rt>><'row mt-2 justify-content-between'<'col-md-auto me-auto'i><'col-md-auto ms-auto'p>>",
                order: [
                    [4, 'desc']
                ],
                buttons: [
                    {
                        extend: 'excel',
                        exportOptions: {
                            columns: ":not(:eq(2))"
                        }
                    }, {
                        extend: 'csv',
                        exportOptions: {
                            columns: ":not(:eq(2))"
                        }
                    }, {
                        extend: 'pdf',
                        exportOptions: {
                            columns: ":not(:eq(2))"
                        },
                        customize: function(doc) {
                            doc.content[1].table.widths =
                                Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                        }
                    }
                ],
                initComplete: function() {
                    $('.dt-buttons').addClass('btn-group-sm')
                },
                ajax: {
                    url: "{{ route('data-table.data-lessons') }}",
                    data: {
                        classroom_id: "{{ $classroom->id }}",
                    }
                },
                columns: [
                    {
                        data: "DT_RowIndex",
                        title: '#',
                        orderable: false,
                        searchable: false,
                    },
                    {
                        data: 'name',
                        title: "Judul",
                    },
                    {
                        data: 'description',
                        title: 'Deskripsi'
                    },
                    {
                        data: 'lesson.name',
                        title: 'Pelajaran'
                    },
                    {
                        data: 'due_date',
                        title: 'Tenggat',
                        render: function(data) {
                            return moment(data).locale('id').format('DD MMMM YYYY')
                        }
                    },
                    {
                        data: 'id',
                        title: "Aksi",
                        render: function(data, type, row) {
                            const data_url = "/api/assignments/export-marks/"+data
                            return `
                                <div class="d-flex gap-2 align-items-center">
                                    <button type="button" class="btn btn-sm btn-light-primary btn-print-assignment" data-url="${data_url}">
                                        Export Nilai
                                    </button>
                                </div>
                            `
                        }
                    }
                ]
            })

            $(document).on('click', '.btn-print-assignment', function() {
                const data_url = $(this).data('url')
                $.ajax({
                    url: data_url,
                    method: "GET",
                    success: function(res) {
                        window.open('{{asset("storage")}}/' + res.path, '_blank')
                    },
                    error: function(xhr) {
                        console.error(xhr)
                    }
                })
            })
        })
    </script>
@endpush
