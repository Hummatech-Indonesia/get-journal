<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Hapus Akun</title>

        <link
            rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        />
    </head>
    <body>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-6 mt-5">
                    <form
                        id="delete-account-form"
                        action="{{ route('processDeleteAccount') }}"
                        method="POST"
                    >
                        @csrf
                        <div class="card">
                            <div class="card-header">
                                <h4>Hapus Akun</h4>
                            </div>
                            <div class="card-body">
                                <p>
                                    Semua data yang berkaitan dengan akun anda
                                    akan terhapus. Pastikan anda yakin untuk
                                    menghapus akun anda.
                                </p>

                                <div>
                                    <label for="email">E-mail</label>
                                    <input
                                        id="email"
                                        type="email"
                                        class="form-control"
                                        placeholder="example@gmail.com"
                                        name="email"
                                    />
                                </div>
                                <div class="mt-3">
                                    <label for="password">Password</label>
                                    <input
                                        id="password"
                                        type="password"
                                        class="form-control"
                                        placeholder="password"
                                        name="password"
                                    />
                                </div>
                            </div>
                            <div class="card-footer d-flex justify-content-end">
                                <button
                                    type="button"
                                    id="btn-delete"
                                    class="btn btn-danger"
                                >
                                    Hapus Akun
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script
            src="https://code.jquery.com/jquery-3.7.1.min.js"
            integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
            crossorigin="anonymous"
        ></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

        <script>
            $(document).ready(function () {
                $("#btn-delete").click(function () {
                    var dialog = confirm(
                        "Apakah anda yakin untuk menghapus akun anda?"
                    );
                    if (dialog) {
                        $("#delete-account-form").submit();
                    }
                });
            });
        </script>
    </body>
</html>
