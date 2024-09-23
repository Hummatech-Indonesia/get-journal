<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name', "Jurnal Mengajar") }}</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
    <link rel="stylesheet" href="{{ asset('assets/plugins/global/plugins.bundle.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.bundle.css') }}">
    <!--end::Global Stylesheets Bundle-->
</head>
<body>
    <div class="container">

        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-center align-items-center mb-5">
                    <img src="{{asset('assets/logo/logo_3.png')}}" alt="logo mi-jurnal" style="height: 50px;">
                </div>
                <h1 class="text-center">Reset Password</h1>
                <p class="lead">
                    Anda telah melakukan permintaan untuk mengubah password anda. Jika memang anda yang melakukan permintaan, silahkan klik tombol di bawah ini.
                </p>
                <div class="d-flex align-items-center justify-content-center">
                    <a href="{{ $url }}" class="btn btn-primary mx-auto my-4 text-white">Reset Password</a>
                </div>
                <p class="lead">
                    Jika anda tidak merasa melakukan permintaan, silahkan abaikan email ini.
                </p>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
</body>
</html>