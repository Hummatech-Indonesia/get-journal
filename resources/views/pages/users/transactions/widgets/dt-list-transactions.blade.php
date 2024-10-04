<div class="card">
    <div class="card-body table-responsive">
        <div class="alert alert-warning" role="alert">
            Jika ingin melakukan cetak data, pastikan kolom "entries per page" bernilai "semua"
        </div>
        <table class="table align-middle" id="dt-transactions"></table>
    </div>
</div>

@push('script')
    <script>
        $(document).ready(function() {
            const dt_transactions = $('#dt-transactions').DataTable({
                language: {
                    processing: 'memuat...'
                },
                processing: true,
                serverSide: true,
                lengthMenu: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, 'Semua']
                ],
                dom: "<'row mt-2 justify-content-between'<'col-md-auto me-auto'B><'col-md-auto ms-auto custom-container'>><'row mt-2 justify-content-between'<'col-md-auto me-auto'l><'col-md-auto me-start'f>><'row mt-2 justify-content-md-center'<'col-12'rt>><'row mt-2 justify-content-between'<'col-md-auto me-auto'i><'col-md-auto ms-auto'p>>",
                order: [
                    @if(Auth::user()->hasRole('admin'))
                    [2, 'desc']
                    @else
                    [1, 'desc']
                    @endif
                ],
                buttons: [
                    {
                        extend: 'excel',
                        exportOptions: {
                            columns: ":not(:eq(5))"
                        }
                    }, {
                        extend: 'csv',
                        exportOptions: {
                            columns: ":not(:eq(5))"
                        }
                    }, {
                        extend: 'pdf',
                        exportOptions: {
                            columns: ":not(:eq(5))"
                        },
                        customize: function(doc) {
                            doc.content[1].table.widths =
                                Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                        }
                    }
                ],
                initComplete: function() {
                    $('.dt-buttons').addClass('btn-group-sm')
                    $('.custom-container').html(`
                        <select class="form-select form-select-sm" id="status">
                            <option value="">Semua Status</option>
                            <option value="UNPAID">Belum Dibayar</option>
                            <option value="PAID">Dibayarkan</option>
                            <option value="EXPIRED">Kedaluwarsa</option>
                        </select>
                    `)
                },
                ajax: {
                    url: "{{ route('payment.v2.list-transaction') }}",
                    data: {
                        @if(!Auth::user()->hasRole('admin'))
                        _token: "{{csrf_token()}}",
                        user_id: "{{auth()->id()}}",
                        @endif
                        status: $('#status').val()
                    }
                },
                columns: [
                    {
                        data: "DT_RowIndex",
                        title: '#',
                        orderable: false,
                        searchable: false
                    },
                    @if(Auth::user()->hasRole('admin'))
                    {
                        data: 'user.profile.name',
                        title: 'Pengguna',
                        render: (data, type, row) => {
                            let img_url = "{{ asset('img_path') }}";
                            img_url = img_url.replace('img_path', (row.user.profile.photo ? row.user.profile.photo : 'assets/media/avatars/blank.png'))
                            return `
                                <div class="d-flex gap-2 align-items-center">
                                    <div class="symbol symbol-50px">
                                        <img src="${img_url}" />
                                    </div>
                                    <div class="d-flex flex-column">
                                        <div class-"fw-semibold">${row.user.profile.name}</div>
                                        <div class="text-muted">${row.user.email}</div>
                                    </div>
                                </div>
                            `
                        }
                    },
                    @endif
                    {
                        data: 'created_at',
                        title: "Tanggal",
                        render: (data) => {
                            return moment(data).format('DD MMMM YYYY hh:mm')
                        }
                    }, {
                        data: 'amount',
                        title: 'Total',
                        render: (data) => {
                            return 'Rp '+formatNum(data, true)
                        }
                    }, {
                        data: 'status',
                        title: "Status",
                        render: (data) => {
                            if(data == 'UNPAID') return '<div class="badge bg-light-warning text-warning">Belum Dibayar</div>'
                            else if(data == 'PAID') return '<div class="badge bg-light-success text-success">Dibayarkan</div>'
                            else return '<div class="badge bg-light-danger text-danger">Kedaluwarsa</div>'
                        }
                    }, {
                        title: "Aksi",
                        mRender: (data, type, row) => {
                            console.log(row)
                            let url = "{{route('transactions.show', 'reference_hehe')}}"
                            url = url.replace('reference_hehe', row['merchant_ref'])
                            let return_el = '<div class="d-flex gap-2 align-items-center justify-content-center">'
                            return_el += `
                                <a href="${url}" class="btn btn-sm btn-light-primary">
                                    Detail
                                </a>
                            `
                            if(row['status'] == 'UNPAID') return_el += `
                                <a href="${row['checkout_url']}" target="_blank" class="btn btn-sm btn-light-success">
                                    Bayar
                                </a>
                            `
                            return_el += '</div>'

                            return return_el
                        }
                    }
                ]
            })

            $(document).on('change', '#status', function() {
                @if(!Auth::user()->hasRole('admin'))
                const new_url = `{{ route('payment.v2.list-transaction') }}?user_id={{auth()->id()}}&status=${$('#status').val()}`
                @else
                const new_url = `{{ route('payment.v2.list-transaction') }}?status=${$('#status').val()}`
                @endif
                dt_transactions.ajax.url(new_url).load()
            })
        })
    </script>
@endpush