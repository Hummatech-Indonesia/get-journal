<div class="card mt-5">
    <div class="card-header">
        <h5 class="card-title">Daftar Nilai Siswa</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table align-middle" id="dt-marks"></table>
        </div>
    </div>
</div>

@push('script')
    <script>
        $(document).ready(function() {
            const dt_marks = $('#dt-marks').DataTable({
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
                    [5, 'desc']
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
                    url: "{{ route('data-table.data-marks') }}",
                    data: function(d){
                        d.student_id = '{{ $student->id }}'
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
                        data: 'assignment.lesson.name',
                        title: "Mata Pelajaran"
                    },
                    {
                        title: "Nama Tugas",
                        data: 'assignment.name'
                    },
                    {
                        title: "Deskripsi Tugas",
                        data: 'assignment.description'
                    },
                    {
                        title: "Nilai",
                        data: "score",
                        render: (data) => {
                            return `<span class="badge bg-light-primary text-primary">${(data != null ? data : '-')}</span>`
                        }
                    },
                    {
                        title: 'Tanggal Tugas Dibuat',
                        data: 'assignment.created_at',
                        render: (data) => {
                            return moment(data).locale('id').format('DD MMMM YYYY')
                        }
                    }
                ]
            })
        })
    </script>
@endpush