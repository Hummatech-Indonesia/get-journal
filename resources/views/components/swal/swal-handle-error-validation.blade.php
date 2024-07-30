@push('script')
    @if ($errors->any())
        <script>
            $(document).ready(function() {
                let error_message = ''
                @foreach ($errors->all() as $error)
                    error_message+= `{{ $error }} <br />`
                @endforeach

                Swal.fire({
                    icon: 'error',
                    title: 'Kesalahan Input',
                    html: `${error_message.replaceAll('`', "'")}`
                })
            })
        </script>
    @endif
@endpush