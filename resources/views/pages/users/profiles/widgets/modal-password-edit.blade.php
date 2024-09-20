<div class="modal fade" id="changePasswordModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{route('web.update-password')}}" method="post" class="modal-content">
            @csrf
            <input type="hidden" name="type" value="web">
            <div class="modal-header">
                <h5 class="modal-title">Ubah Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="form-group mb-3">
                    <label for="password">Password Lama</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" placeholder="password lama" name="password" id="password">
                    @error('password')
                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="new_password">Password Baru</label>
                    <input type="password" class="form-control @error('new_password') is-invalid @enderror" placeholder="password baru" name="new_password" id="new_password">
                    @error('new_password')
                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="confirm_password">Konfirmasi Password Baru</label>
                    <input type="password" class="form-control @error('confirm_password') is-invalid @enderror" placeholder="password baru" name="confirm_password" id="confirm_password">
                    @error('confirm_password')
                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Ubah</button>
            </div>
        </form>
    </div>
</div>