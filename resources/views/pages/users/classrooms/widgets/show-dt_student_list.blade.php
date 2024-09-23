<div class="d-flex justify-content-between align-items-center">
    <a href="{{ route('classes.index') }}" class="btn btn-primary btn-sm">&LeftArrow; Kembali</a>
    <ul class="nav nav-tabs nav-line-tabs nav-line-tabs-2x mb-5 fs-6">
        <li class="nav-item">
            <a class="nav-link active" data-bs-toggle="tab" href="#pane_siswa">Siswa</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#pane_jurnal">Jurnal</a>
        </li>
    </ul>
</div>

<div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="pane_siswa" role="tabpanel">
        @include('pages.users.classrooms.panes.student')
    </div>
    <div class="tab-pane fade show" id="pane_jurnal" role="tabpanel">
        @include('pages.users.classrooms.panes.journal')
    </div>
</div>
