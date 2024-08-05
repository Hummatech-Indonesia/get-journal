<div class="card">
    <div class="card-body table-responsive">
        <table class="table align-middle" id="dt-teachers"></table>
    </div>
</div>

@push('script')
    <script>
        $(document).ready(function() {
            const dt_teachers = $('#dt-teachers').DataTable({
                language: {
                    processing: 'memuat...'
                },
                processing: true,
                serverSide: true,
                lengthMenu: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, 'Semua']
                ],
                dom: "<'row mt-2 justify-content-between'<'col-md-auto me-auto'B><'col-md-auto ms-auto input-date-container'>><'row mt-2 justify-content-between'<'col-md-auto me-auto'l><'col-md-auto me-start'f>><'row mt-2 justify-content-md-center'<'col-12'rt>><'row mt-2 justify-content-between'<'col-md-auto me-auto'i><'col-md-auto ms-auto'p>>",
                order: [
                    // [1, 'asc']
                ],
                buttons: [
                    {
                        extend: 'excel',
                        exportOptions: {
                            columns: ":not(:eq(5))"
                        }
                    }, {
                        extend: 'csv',
                        exportOptions: {
                            columns: ":not(:eq(5))"
                        }
                    }, {
                        extend: 'pdf',
                        exportOptions: {
                            columns: ":not(:eq(5))"
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
                    url: "{{ route('data-table.data-user') }}",
                    data: {
                        role: 'teacher',
                        school_id: "{{ auth()->id() }}"
                    }
                },
                columns: [
                    {
                        data: "DT_RowIndex",
                        title: "No.",
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'profile.name',
                        title: "Guru",
                        render: (data, type, row) => {
                            const img = (row.profile.photo ? row.profile.photo : '/assets/media/avatars/blank.png')
                            return `
                                <div class="d-flex align-items-center gap-1">
                                    <div class="symbol symbol-50px">
                                        <img src="${img}" alt="gambar guru"/>
                                    </div>
                                    <div class="d-flex flex-column justify-content-between">
                                        <div class="fw-bold">${row.profile.name}</div>
                                        <div class="text-muted">${row.email}</div>
                                    </div>
                                </div>
                            `
                        }
                    },
                    {
                        title: 'Aksi',
                        mRender: (data, type, row) => {
                            return `
                                <div>
                                    <button class="btn btn-icon btn-sm btn-active-light-primary">
                                        <i class="ki-duotone ki-eye fs-3">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                        </i>
                                    </button>
                                </div>
                            `
                        }
                    }
                ]
            })
        })
    </script>
@endpush
