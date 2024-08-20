<form action="#" class="card" method="POST">
    @csrf
    <div class="card-body table-responsive">
        <div class="alert alert-warning" role="alert">
            Jika ingin melakukan cetak data, pastikan kolom "entries per page" bernilai "semua"
        </div>
        <table class="table align-middle" id="dt-teachers"></table>
    </div>
</form>

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
                dom: "<'row mt-2 justify-content-between'<'col-md-auto me-auto'B><'col-md-auto ms-auto custom-container'>><'row mt-2 justify-content-between'<'col-md-auto me-auto'l><'col-md-auto me-start'f>><'row mt-2 justify-content-md-center'<'col-12'rt>><'row mt-2 justify-content-between'<'col-md-auto me-auto'i><'col-md-auto ms-auto'p>>",
                order: [
                    [1, 'asc']
                ],
                buttons: [
                    {
                        extend: 'excel',
                        exportOptions: {
                            columns: function(idx, data, node) {
                                return idx !== 0 && idx !== 3
                            }
                        }
                    }, {
                        extend: 'csv',
                        exportOptions: {
                            columns: function(idx, data, node) {
                                return idx !== 0 && idx !== 3
                            }
                        }
                    }, {
                        extend: 'pdf',
                        exportOptions: {
                            columns: function(idx, data, node) {
                                return idx !== 0 && idx !== 3
                            }
                        },
                        customize: function(doc) {
                            doc.content[1].table.widths =
                                Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                        }
                    }
                ],
                initComplete: function() {
                    $('.dt-buttons').addClass('btn-group-sm')
                    $('.custom-container').html('<button type="submit" class="btn btn-sm btn-primary" id="submit-premium">Jadikan Premium</button>')
                    isCanSubmitPremium()
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
                        data: "id",
                        title: '<div class="form-check"><input type="checkbox" class="form-check-input" id="check-all-teacher" /></div>',
                        render: (data, type, row) => {
                            if(!row['user_premium']) return `<div class="form-check"><input type="checkbox" class="check-teacher form-check-input" value="${data}" name="teacher_ids" /></div>`
                            return ''
                        },
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
                        }
                    },
                    {
                        data: 'user_premium',
                        title: "Premium",
                        render: (data, type) => {
                            if(data) return `<span class="badge bg-light-primary text-primary">Premium</span>`
                            return `<span class="badge bg-light-warning text-warning">Non-Premium</span>`
                        }
                    },
                    {
                        title: 'Aksi',
                        mRender: (data, type, row) => {
                            return `
                                <div>
                                    <button class="btn btn-icon btn-sm btn-active-light-primary">
                                        <i class="ki-duotone ki-eye fs-1">
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
