<div class="card">
    <div class="card-body table-responsive">
        <div class="alert alert-warning" role="alert">
            Jika ingin melakukan cetak data, pastikan kolom "entries per page" bernilai "semua"
        </div>
        <table class="table align-middle" id="dt-journals"></table>
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
            const dt_journals = $('#dt-journals').DataTable({
                language: {
                    processing: 'memuat...'
                },
                processing: true,
                serverSide: true,
                lengthMenu: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, 'Semua']
                ],
                dom: "<'row mt-2 justify-content-between'<'col-md-auto me-auto'B><'col-md-auto ms-auto custom-container-journal'>><'row mt-2 justify-content-between'<'col-md-auto me-auto'l><'col-md-auto me-start'f>><'row mt-2 justify-content-md-center'<'col-12'rt>><'row mt-2 justify-content-between'<'col-md-auto me-auto'i><'col-md-auto ms-auto'p>>",
                order: [
                    [1, 'asc']
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
                    $('.custom-container-journal').html(`<button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modal-download-journal">Cetak Laporan Jurnal</button>`)
                    isCanSubmitPremium()
                },
                ajax: {
                    url: "{{ route('data-table.data-journals') }}",
                    data: {
                        classroom_id: "{{ $classroom->id }}",
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
                    },
                    {
                        title: "Aksi",
                        mRender: function(data, type, row) {
                            const data_str = JSON.stringify(row).replaceAll('"', "`")
                            return `
                                <div class="d-flex gap-2 align-items-center">
                                    <button type="button" class="btn btn-sm btn-light-primary btn-show-description" data-bs-toggle="modal" data-bs-target="#modal-detail" data-detail="${data_str}">
                                        Detail
                                    </button>
                                </div>
                            `
                        }
                    }
                ]
            })

            $(document).on('click', '#btn-submit-download-journal', function() {
                $.ajax({
                    url: "{{ url('api/journals/export') }}",
                    method: "POST",
                    data: {
                        classroom_id: "{{ $classroom->id }}",
                        start_date: $('#start_date').val(),
                        end_date: $('#end_date').val(),
                        filename: $('#filename').val(),
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(res) {
                        window.open('{{asset("storage")}}/' + res.url, '_blank')
                    },
                    error: function(xhr) {
                        console.error(xhr)
                    }
                })
            })

            $(document).on('click', '.btn-show-description', function() {
                const detail = JSON.parse($(this).data('detail').replaceAll('`', '"'))
                $('#modal-detail .modal-body #description').html(detail.description.replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1<br />$2'))
                const list_permit = detail.permit.map((item) => item.profile.name).join(', ')
                const list_sick = detail.sick.map((item) => item.profile.name).join(', ')
                const list_alpha = detail.alpha.map((item) => item.profile.name).join(', ')
                $('#modal-detail .modal-body #permit').html(list_permit ? list_permit : '-')
                $('#modal-detail .modal-body #sick').html(list_sick ? list_sick : '-')
                $('#modal-detail .modal-body #alpha').html(list_alpha ? list_alpha : '-')
            })

            $(document).on('change', '#check-all-teacher', function() {
                $('.check-teacher').prop('checked', $(this).prop('checked'))
                isCanSubmitPremium()
            })

            $(document).on('change', '.check-teacher', function() {
                const checked = $('.check-teacher:checked').length
                const all_check_teacher = $('.check-teacher').length

                if(checked == 0) $('#check-all-teacher').prop('checked', false)
                else if(checked == all_check_teacher) $('#check-all-teacher').prop('checked', true)
                else {
                    $('#check-all-teacher').prop('checked', false)
                    $('#check-all-teacher').prop('indeterminate', true)
                }
                isCanSubmitPremium()
            })

            function isCanSubmitPremium() {
                if(!$('.check-teacher:checked').length) $('#submit-premium').addClass('disabled')
                else $('#submit-premium').removeClass('disabled')
            }
        })
    </script>
@endpush
