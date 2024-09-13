<div class="modal fade" id="editProfileModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ubah Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="form-group mb-3">
                    <label for="name">Nama</label>
                    <input type="text" class="form-control" placeholder="nama" name="name" id="name" value="{{ auth()->user()->profile->name }}">
                </div>
                <div class="form-group mb-3">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" placeholder="nama" name="name" id="name" value="{{ auth()->user()->email }}">
                </div>
                <div class="form-group mb-3">
                    <label for="address">Alamat</label>
                    <textarea name="address" id="address" class="form-control" placeholder="alamat">{{ auth()->user()->profile->address }}</textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Ubah</button>
            </div>
        </div>
    </div>
</div>