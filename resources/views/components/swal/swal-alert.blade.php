@push('script')
    @if(session()->has('error') || session()->has('success'))
    <script>
        $(document).ready(function() {
            @if(session()->has('error'))
                Swal.fire({
                    toast: true,
                    icon: "error",
                    title: "{{ session('error') }}",
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true,
                })
            @endif
            @if(session()->has('success'))
            Swal.fire({
                toast: true,
                icon: "success",
                title: "{{ session('success') }}",
                position: "top-end",
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
            })
            @endif
        })
    </script>
    @endif
@endpush