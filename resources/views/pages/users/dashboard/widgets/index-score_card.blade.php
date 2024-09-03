<div class="row mb-5">
    <div class="col-12 col-md-6 col-lg-3">
        <div class="card card-dashboard  position-relative overflow-hidden">
            <div class="card-body p-5">
                <h2 class="m-0">Guru</h2>
                <div class="text-info fs-2tx fw-bold">{{ $data->teacher }}</div>
                <i class="position-absolute opacity-25 ki-duotone ki-teacher text-info fs-6tx ">
                    <div class="path1"></div><div class="path2"></div>
                </i>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6 col-lg-3">
        <div class="card card-dashboard  position-relative overflow-hidden">
            <div class="card-body p-5">
                <h2 class="m-0">Siswa</h2>
                <div class="text-primary fs-2tx fw-bold">{{ $data->student }}</div>
                <i class="position-absolute opacity-25 ki-duotone ki-briefcase text-primary fs-6tx ">
                    <div class="path1"></div><div class="path2"></div>
                </i>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6 col-lg-3">
        <div class="card card-dashboard  position-relative overflow-hidden">
            <div class="card-body p-5">
                <h2 class="m-0">Kelas</h2>
                <div class="text-success fs-2tx fw-bold">{{ $data->classroom }}</div>
                <i class="position-absolute opacity-25 ki-duotone ki-book-open text-success fs-6tx ">
                    <div class="path1"></div><div class="path2"></div><div class="path3"></div><div class="path4"></div>
                </i>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6 col-lg-3">
        <div class="card card-dashboard  position-relative overflow-hidden">
            <div class="card-body p-5">
                <h2 class="m-0">Sisa Premium</h2>
                <div class="text-warning fs-2tx fw-bold">{{ $data->premium }}</div>
                <i class="position-absolute opacity-25 ki-duotone ki-medal-star text-warning fs-6tx ">
                    <div class="path1"></div><div class="path2"></div><div class="path3"></div><div class="path4"></div>
                </i>
            </div>
        </div>
    </div>
</div>