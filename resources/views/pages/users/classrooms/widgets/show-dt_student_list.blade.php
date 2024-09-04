<div class="card">
    <div class="card-body table-responsive">
        <div class="alert alert-warning" role="alert">
            Jika ingin melakukan cetak data, pastikan kolom "entries per page" bernilai "semua"
        </div>
        <table class="table align-middle" id="dt-students"></table>
    </div>
</div>

@push('script')
    <script>
        $(document).ready(function() {
            const dt_students = $('#dt-students').DataTable({
                language: {
                    processing: 'memuat...'
                },
                processing: true,
                serverSide: true,
                lengthMenu: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, 'Semua']
                ],
                dom: "<'row mt-2 justify-content-between'<'col-md-auto me-auto'B><'col-md-auto ms-auto custom-container'>><'row mt-2 justify-content-between'<'col-md-auto me-auto'l><'col-md-auto me-start'f>><'row mt-2 justify-content-md-center'<'col-12'rt>><'row mt-2 justify-content-between'<'col-md-auto me-auto'i><'col-md-auto ms-auto'p>>",
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
                    isCanSubmitPremium()
                },
                ajax: {
                    url: "{{ route('data-table.data-students') }}",
                    data: {
                        role: 'student',
                        classroom_id: "{{ $classroom->id }}",
                        code: "{{ auth()->user()->profile->code }}"
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
                        data: 'name',
                        title: "Siswa",
                        render: (data, type, row) => {
                            console.log(row)
                            const img = (row.photo ? row.photo : '/assets/media/avatars/blank.png')
                            return `
                                <div class="d-flex align-items-center gap-1">
                                    <div class="symbol symbol-50px">
                                        <img src="${img}" alt="gambar guru"/>
                                    </div>
                                    <div class="d-flex flex-column justify-content-between">
                                        <div class="fw-bold">${row.name}</div>
                                        <div class="text-muted">${row.user.email}</div>
                                    </div>
                                </div>
                            `
                        }
                    },
                    {
                        title: "Ketidakhadiran",
                        mRender: (data, type, row) => {
                            return `
                                <div class="d-flex gap-3">
                                    <span class="badge badge-light-success text-success">3 Izin</span>
                                    <span class="badge badge-light-primary text-primary">3 Sakit</span>
                                    <span class="badge badge-light-danger text-danger">3 Tanpa Keterangan</span>
                                </div>
                            `
                        }
                    },
                    {
                        title: "Tugas",
                        mRender: (data, type, row) => {
                            return `<span class="badge badge-light-primary text-primary">3 Tugas</span>`
                        }
                    },
                    {
                        title: 'Aksi',
                        mRender: (data, type, row) => {
                            let detail_url = "{{ route('student.show', 'data_id') }}"
                            detail_url = detail_url.replace('data_id', row.id)
                            return `
                                <div>
                                    <a href="${detail_url}" class="btn btn-icon btn-sm btn-active-light-primary">
                                        <i class="ki-duotone ki-eye fs-1">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                        </i>
                                    </a>
                                </div>
                            `
                        }
                    }
                ]
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
