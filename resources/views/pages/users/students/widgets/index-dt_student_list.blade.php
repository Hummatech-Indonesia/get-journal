<div class="card">
    <div class="card-body table-responsive">
        <div class="alert alert-warning" role="alert">
            Jika ingin melakukan cetak data, pastikan kolom "entries per page" bernilai "semua"
        </div>
        <div class="d-flex gap-2 align-items-center" id="filter">
            <div class="form-group" id="filter-teacher">
                <select name="teacher" id="teacher" class="form-select form-select-sm">
                    <option value="">Filter Guru</option>
                </select>
            </div>
            <div class="form-group" id="filter-class" style="display: none">
                <select name="class" id="class" class="form-select form-select-sm">
                    <option value="">Filter Kelas</option>
                </select>
            </div>
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
                    const filter = $('#filter').detach()
                    $('.custom-container').append(filter)
                    getTeacher()
                    isCanSubmitPremium()
                },
                ajax: {
                    url: "{{ route('data-table.data-students') }}",
                    data: function(d){
                        d.role = 'student',
                        d.code = "{{ auth()->user()->profile->code }}",
                        d.teacher_id = $('#teacher').val(),
                        d.classroom_id = $('#class').val()
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
                    // {
                    //     title: "Jumlah Kelas",
                    //     mRender: (data, type, row) => {
                    //         console.log({row})
                    //         return '<span class="badge badge-light-success text-success">3 kelas</span>'
                    //     }
                    // },
                    {
                        title: 'Aksi',
                        mRender: (data, type, row) => {
                            let detail_url = "{{ route('student.show', 'data_id') }}"
                            detail_url = detail_url.replace('data_id', row.id)
                            return `
                                <div>
                                    <a href="${detail_url}" class="btn btn-sm btn-light-primary">
                                        Detail
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

            function getTeacher() {
                $.ajax({
                    url: "/api/auth/list/users",
                    data: {
                        role: 'teacher',
                        code: "{{ auth()->user()->profile?->code }}"
                    },
                    success: (row) => {
                        const teachers = row.data
                        let teacher_option = `<option value="">Filter Guru</option>`
                        teachers.forEach((item, index) => {
                            teacher_option += `<option value="${item.profile.id}">${item.name}</option>`
                        })
                        $('#teacher').html(teacher_option)
                    }, error: (xhr) => {
                        console.error(xhr)
                    }
                })
            }

            function getClass() {
                $('#class').val('')
                if($('#teacher').val()) $('#filter-class').show()
                else $('#filter-class').hide()

                $.ajax({
                    url: "/api/auth/list/classrooms-no-paginate",
                    data: {
                        teacher_id: $('#teacher').val(),
                        _token: "{{ csrf_token() }}",
                        user_id: "{{ auth()->id() }}"
                    },
                    success: (row) => {
                        const classrooms = row.data
                        let class_option = `<option value="">Filter Kelas</option>`
                        classrooms.forEach((item, index) => {
                            class_option += `<option value="${item.id}">${item.name}</option>`
                        })
                        $('#class').html(class_option)
                    }, error: (xhr) => {
                        console.error(xhr)
                    }
                })
            }

            $(document).on('change', '#teacher', function() {
                getClass()
                reloadData()
            })

            $(document).on('change', '#class', function() {
                reloadData()
            })

            function isCanSubmitPremium() {
                if(!$('.check-teacher:checked').length) $('#submit-premium').addClass('disabled')
                else $('#submit-premium').removeClass('disabled')
            }

            function reloadData() {
                dt_students.ajax.reload()
            }
        })
    </script>
@endpush
