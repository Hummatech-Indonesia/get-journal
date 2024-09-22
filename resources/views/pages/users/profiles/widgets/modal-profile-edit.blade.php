<div class="modal fade" id="editProfileModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{route('web.update-profile')}}" method="post" class="modal-content" enctype="multipart/form-data">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Ubah Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="type" value="web" />
                <div class="form-group mb-3">
                    <label for="photo">Foto Profil</label>
                    <input type="file" class="form-control @error('photo') is-invalid @enderror" accept=".jpg,.jpeg,.png" name="photo" id="photo">
                    @error('photo')
                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="name">Nama</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="nama" name="name" id="name" value="{{ old('name', auth()->user()->profile->name) }}">
                    @error('name')
                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="email">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" placeholder="email" name="email" id="email" value="{{ old('email', auth()->user()->email) }}">
                    @error('email')
                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="telp">No. Telp</label>
                    <input type="text" class="form-control only-num @error('telp') is-invalid @enderror" placeholder="no telp" name="telp" id="telp" value="{{ old('telp', auth()->user()->profile->telp) }}">
                    @error('telp')
                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="address">Alamat</label>
                    <textarea name="address" id="address" class="form-control @error('address') is-invalid @enderror" placeholder="alamat">{{ old('address', auth()->user()->profile->address) }}</textarea>
                    @error('address')
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

@push('script')
    <script>
        $(document).ready(function() {
            $(document).on('input', '.only-num', function() {
                $(this).val($(this).val().replace(/[^0-9]/g, ''))
            })
        })
    </script>
@endpush