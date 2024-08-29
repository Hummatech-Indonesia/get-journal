<div class="card">
    <div class="card-body">
        <h4>Guru Terbaru</h4>
        <div class="table-responsive">
            <table class="table align-middle" id="dt-newest-teacher"></table>
        </div>
    </div>
</div>

@push('script')
    <script>
        $(document).ready(function() {
            const dt_teachers = $('#dt-newest-teacher').DataTable({
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
                    url: "{{ route('data-table.data-user') }}",
                    data: {
                        role: 'teacher',
                        school_id: "{{ auth()->id() }}"
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
                        },
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'user_premium',
                        title: "Premium",
                        render: (data, type) => {
                            if(data) return `<span class="badge bg-light-primary text-primary">Premium</span>`
                            return `<span class="badge bg-light-warning text-warning">Non-Premium</span>`
                        },
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'created_at',
                        title: 'Tanggal Pendaftaran',
                        render: (data) => {
                            return moment(data).format('LL')
                        }, orderable: false
                    }
                ]
            })
        })
    </script>
@endpush