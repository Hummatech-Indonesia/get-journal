<div class="d-flex justify-content-between align-items-center mb-3">
    <ul class="nav nav-tabs nav-line-tabs nav-line-tabs-2x fw-bolder">
        <li class="nav-item">
            <a class="nav-link text-primary active" data-bs-toggle="tab" href="#pane_siswa">Siswa</a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-primary" data-bs-toggle="tab" href="#pane_jurnal">Jurnal</a>
        </li>
    </ul>
    <a href="{{ route('classes.index') }}" class="btn btn-dark btn-sm">&LeftArrow; Kembali</a>
</div>

<div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="pane_siswa" role="tabpanel">
        @include('pages.users.classrooms.panes.student')
    </div>
    <div class="tab-pane fade show" id="pane_jurnal" role="tabpanel">
        @include('pages.users.classrooms.panes.journal')
    </div>
</div>
