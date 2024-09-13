<div class="modal" tabindex="-1" id="user-detail-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Detail Pengguna</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex pb-3 justify-content-between border-bottom">
                    <div class="d-flex gap-5 align-items-stretch">
                        <div>
                            <div class="symbol symbol-100px">
                                <img src="" alt="" class="object-fit-cover" id="user-img">
                            </div>
                        </div>
                        <div class="d-flex flex-column justify-content-between">
                            <div>
                                <h5 class="fw-bold m-0" id="user-name">Nama Guru</h5>
                                <div class="lead" id="user-email">emailguru@gmail.com</div>
                                <div class="text-muted" id="user-id">92374923</div>
                            </div>
                            <div id="is-premium"><span class="badge bg-light-warning text-warning">Non Premium</span></div>
                        </div>
                    </div>
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
        $(document).on('click', '.btn-user-detail', function() {
            let data_user = JSON.parse($(this).data('user').replaceAll("`", '"'))
            let user_photo = (data_user.profile?.photo ? "{{asset('storage')}}"+data_user.profile.photo : "{{asset('assets/media/avatars/blank.png')}}")
            $('#user-detail-modal #user-img').attr('src', user_photo)
            $('#user-detail-modal #user-name').text(data_user.name)
            $('#user-detail-modal #user-email').text(data_user.email)
            $('#user-detail-modal #user-id').text(data_user.profile?.identity_number)
            $('#user-detail-modal #is-premium').html((
                parseInt(data_user.profile?.is_premium) ?
                '<span class="badge badge-light-primary text-primary">Premium</span>' :
                '<span class="badge badge-light-warning text-warning">Non Premium</span>'
            ))
            $('#user-detail-modal #class-count').text('Kelas : '+data_user.profile?.classrooms.length)
            
            let data_classrooms = ''

            console.log({data_user})
            data_user.profile?.classrooms.forEach((room, index) => {
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

            $('#user-detail-modal #class-list').html(data_classrooms)

            console.log({data_user, data_classrooms})
        })
    </script>
@endpush