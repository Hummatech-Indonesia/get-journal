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
                    [1, 'asc']
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
                    $('.custom-container').html('<button type="submit" class="btn btn-sm btn-primary" id="submit-premium">Jadikan Premium</button>')
                },
                ajax: {
                    url: "{{ route('payment.v2.list-transaction') }}",
                    data: {
                        _token: "{{csrf_token()}}"
                    }
                },
                columns: [
                    {
                        data: "DT_RowIndex",
                        title: '#',
                        orderable: false,
                        searchable: false
                    },
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
                            let url = "{{route('transactions.show', 'reference_hehe')}}"
                            url = url.replace('reference_hehe', row['merchant_ref'])
                            let return_el = '<div class="d-flex gap-2 align-items-center justify-content-center">'
                            return_el += `
                                <a href="${url}" class="btn btn-icon btn-sm btn-active-light-primary">
                                    <i class="ki-duotone ki-dots-square fs-1">
                                        <div class="path1"></div>
                                        <div class="path2"></div>
                                        <div class="path3"></div>
                                        <div class="path4"></div>
                                    </i>
                                </a>
                            `
                            if(row['status'] == 'UNPAID') return_el += `
                                <a href="${row['checkout_url']}" target="_blank" class="btn btn-icon btn-sm btn-active-light-primary">
                                    <i class="ki-duotone ki-credit-cart fs-1">
                                        <div class="path1"></div>
                                        <div class="path2"></div>
                                    </i>
                                </a>
                            `
                            return_el += '</div>'

                            return return_el
                        }
                    }
                ]
            })
        })
    </script>
@endpush