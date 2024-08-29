<div class="modal" tabindex="-1" id="teacher-detail-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Detail Guru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex pb-3 justify-content-between border-bottom">
                    <div class="d-flex gap-5 align-items-stretch">
                        <div>
                            <div class="symbol symbol-100px">
                                <img src="" alt="" class="object-fit-cover" id="teacher-img">
                            </div>
                        </div>
                        <div class="d-flex flex-column justify-content-between">
                            <div>
                                <h5 class="fw-bold m-0" id="teacher-name">Nama Guru</h5>
                                <div class="lead" id="teacher-email">emailguru@gmail.com</div>
                                <div class="text-muted" id="teacher-id">92374923</div>
                            </div>
                            <div id="is-premium"><span class="badge bg-light-warning text-warning">Non Premium</span></div>
                        </div>
                    </div>
                    <form method="post" id="unlink-form" action="">
                        @csrf
                        <button type="button" class="btn btn-sm btn-primary" id="unlink-btn">Unlink</button>
                    </form>
                </div>
                <div class="pt-3">
                    <div class="mb-3"><span class="badge badge-lg bg-light-primary text-primary" id="class-count">Kelas : 3</span></div>
                    <div class="row align-items-stretch" id="class-list">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('script')
    <script>
        $(document).on('click', '.btn-teacher-detail', function() {
            let data_teacher = JSON.parse($(this).data('teacher').replaceAll("`", '"'))
            let teacher_photo = (data_teacher.profile.photo ? "{{asset('storage')}}"+data_teacher.profile.photo : "{{asset('assets/media/avatars/blank.png')}}")
            $('#teacher-detail-modal #teacher-img').attr('src', teacher_photo)
            $('#teacher-detail-modal #teacher-name').text(data_teacher.name)
            $('#teacher-detail-modal #teacher-email').text(data_teacher.email)
            $('#teacher-detail-modal #teacher-id').text(data_teacher.profile.identity_number)
            $('#teacher-detail-modal #is-premium').html((
                parseInt(data_teacher.profile.is_premium) ?
                '<span class="badge badge-light-primary text-primary">Premium</span>' :
                '<span class="badge badge-light-warning text-warning">Non Premium</span>'
            ))
            $('#teacher-detail-modal #class-count').text('Kelas : '+data_teacher.profile.classrooms.length)
            let action_url = "{{route('teachers.unlink', 'selected_id')}}"
            action_url = action_url.replace('selected_id', data_teacher.id)
            $('#teacher-detail-modal #unlink-form').attr('action', action_url)
            
            let data_classrooms = ''

            console.log({data_teacher})
            data_teacher.profile.classrooms.forEach((room, index) => {
                data_classrooms += `
                    <div class="col-12 col-lg-6 pb-5">
                        <div class="card bg-light-primary w-100">
                            <div class="card-body p-4 d-flex gap-0 flex-column justify-content-between">
                                <div class="lead mb-0 text-primary fs-3">${room.name}</div>
                                <div>
                                    <span class="badge badge-xl bg-primary text-white rounded">${room.code}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                `
            })

            $('#teacher-detail-modal #class-list').html(data_classrooms)

            console.log({data_teacher, data_classrooms})
        })

        $(document).on('click', '#teacher-detail-modal #unlink-btn', function() {
            $('#teacher-detail-modal').modal('hide')
            Swal.fire({
                title: 'Apakah kamu yakin?',
                text : 'Anda mungkin akan kehilangan beberapa data siswa dan premium dari guru premium tidak akan dikembalikan kepada anda!',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yakin',
                cancelButtonText: 'Batal',
            }).then((res) => {
                if(res.isConfirmed) {
                    $('#teacher-detail-modal #unlink-form').submit()
                }
            })
        })
    </script>
@endpush