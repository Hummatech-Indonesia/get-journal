@extends('layouts.auth')

@section('title', 'Detail Transaksi')

@section('content')
    @include('components.swal')
    <div class="row">
        <div class="col-6">
            <div class="card mb-5">
                <div class="card-body">
                    <h5 class="fw-bold">Detail Transaksi</h5>
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="text-muted">Transaksi</div>
                        <div>{{ $data->reference }}</div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="text-muted">Status</div>
                        <div>{{ $data->status }}</div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="text-muted">Metode Pembayaran</div>
                        <div>{{ $data->payment_name }}</div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="fw-bold">Instruksi Pembayaran</h5>
                    <div id="instructions" class="accordion accordion-icon-toggle"></div>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card mb-5">
                <div class="card-body">
                    <h5 class="fw-bold">Item</h5>
                    <div id="item_lists"></div>
                </div>
            </div>
            <div class="d-flex flex-column gap-3">
                @if($data->status == "UNPAID")
                <a href="{{ $data->checkout_url }}" target="_blank"
                    class="btn btn-sm btn-primary d-flex gap-2 justify-content-center align-items-center"><i
                        class="ki-duotone ki-credit-cart fs-1"><span class="path1"></span><span class="path2"></span></i>
                    Bayar</a>
                @endif
                <a href="{{ route('transactions.index') }}"
                    class="btn btn-sm btn-dark d-flex gap-2 justify-content-center align-items-center"><i
                        class="ki-duotone ki-double-left fs-1"><span class="path1"></span><span class="path2"></span></i>
                    Kembali</a>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="{{ asset('assets/plugins/custom/number-format/number-format.js') }}"></script>
    <script>
        const transaction = @json($data);
        const instruction = JSON.parse({!! json_encode($data->instructions) !!});
        const items = JSON.parse({!! json_encode($data->order_items) !!});
        console.log(items)

        
        $(function(){
            function drawInstruction() {
                let instruction_element = ''
                instruction.forEach((inst, index) => {
                    let steps = ''
                    inst.steps.forEach((step) => {
                        steps +=  `<li>${step}</li>`
                    })
        
                    instruction_element += `
                        <div class="mb-3">
                            <div class="accordion-header d-flex" data-bs-toggle="collapse" data-bs-target="#instruction-${index}">
                                <span class="accordion-icon">
                                    <i class="ki-duotone ki-arrow-right fs-4"><span class="path1"></span><span class="path2"></span></i>
                                </span>
                                <h6 class="fw-semibold mb-0 ms-4">${inst.title}</h6>
                            </div>
        
                            <div id="instruction-${index}" class="fs-6 collapse ps-10" data-bs-parent="#instructions">
                                <ol>${steps}</ol>
                            </div>
                        </div>
                    `
                })
        
                $('#instructions').html(instruction_element)
            }

            function drawItem() {
                let item_element = ''
                items.forEach((item) => {
                    item_element += `
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="text-muted">SKU</div>
                            <div>${item.sku}</div>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="text-muted">Nama Item</div>
                            <div>${item.name}</div>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="text-muted">Jumlah</div>
                            <div>${formatNum(item.quantity, true)}</div>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="text-muted">Harga</div>
                            <div>Rp ${formatNum(item.price, true)}</div>
                        </div>
                        <hr/>
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="text-muted fw-bold">Total</div>
                            <div class="fw-bold">Rp ${formatNum(item.subtotal, true)}</div>
                        </div>
                    `
                })

                $('#item_lists').html(item_element)
            }

            drawItem()
            drawInstruction()
        })

        console.log(@json($data))
    </script>
@endpush
