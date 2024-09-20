<div class="modal modal-lg fade" tabindex="-1" id="pay-modal">
    <div class="modal-dialog">
        <form class="modal-content" action="{{route('payment.closed-transaction')}}" method="post">
            @csrf
            <input type="hidden" id="premium_type_price">
            <input type="hidden" id="premium_type_name" name="premium_name">
            <input type="hidden" name="order_items[]" value="-">
            <input type="hidden" name="customer_email" value="{{auth()->user()->email}}">
            <input type="hidden" name="customer_name" value="{{auth()->user()->profile->name}}">
            <input type="hidden" name="app_type" value="web">
            <input type="hidden" name="sku">
            <div class="modal-header py-3">
                <h5>Pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body d-flex flex-column flex-lg-row gap-5">
                <div class="d-flex flex-wrap row-gap-2 justify-content-between" id="payment-method">
                </div>
        
                <div class="flex-1 d-flex flex-column gap-2" style="min-width: 250px">
                    <div>
                        <label for=""></label>
                    </div>
                    <div>
                        <div class="row">
                            <div class="col-8">No. Telp</div>
                            <input type="text" class="col-4  border-bottom-input " value="{{ auth()->user()->profile->telp ? auth()->user()->profile->telp : '08' }}" name="phone"/>
                        </div>
                        <div class="row">
                            <div class="col-8">Kuota</div>
                            <input type="text" class="col-4 format-number border-bottom-input input-qty" data-min="1" data-target="[name=qty]" value="1"/>
                            <input type="hidden" name="qty" value="1">
                        </div>
                        <div class="d-flex justify-content-between">
                            <div>Harga Produk</div>
                            <div class="fw-bold">Rp <span id="product-pay"></span></div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <div>Biaya Layanan</div>
                            <div class="fw-bold">Rp <span id="admin-pay"></span></div>
                        </div>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <div class="fs-1">Total</div>
                        <div class="fs-2x fw-bold">Rp <span id="total-pay"></span></div>
                    </div>
                    <button class="btn btn-sm btn-primary w-100">Bayar</button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('script')
    <script>
        function changePrice() {
            let price = $('#premium_type_price').val()
            let qty = parseFloat($('[name=qty]').val())
            let product_price = price * qty

            $('#product-pay').html(formatNum(product_price, true))

            let selected_payment = $('[name=method]:checked')
            let cust_fee = parseFloat((selected_payment.attr('data-fee') ? selected_payment.attr('data-fee') : 0))

            $('#admin-pay').html(formatNum(cust_fee, true))

            let total_price = product_price + cust_fee;
            $('#total-pay').html(formatNum(total_price, true))
        }
        $(document).ready(function() {
            $.ajax({
                url: "{{route('payment.list-channel')}}",
                success: (res) => {
                    let method_list_el = ""
                    res.data.forEach(data => {
                        method_list_el += `
                            <div class="d-flex justify-content-center align-items-center" style="flex: 1 1 auto;">
                                <!--begin::Option-->
                                <input type="radio" class="btn-check" data-min="${data.min_amount}" data-max="${data.max_amount}" data-fee="${data.tax}" name="method" value="${data.code}"  id="${data.code}"/>
                                <label class="btn btn-outline btn-outline-dashed btn-active-light-primary p-3 d-flex flex-column gap-2 align-items-center" for="${data.code}">
                                    <img src="${data.icon_url}" class="object-fit-contain" style="height: 50px; width: 100px; " />
                                    ${!data.icon_url ? '<div class="text-center">'+data.name+'</div>' : ''}
                                </label>
                                <!--end::Option-->
                            </div>
                        `
                    })

                    $('#payment-method').html(method_list_el)
                }
            })

            $(document).on('change', '[name=method]', function() {
                changePrice()
            })
        })

        $(document).on('input', '[name=phone]',function() {
            $(this).val($(this).val().replace(/[^0-9]/g, ''))
        })

        $(document).on('input', function() {
            changePrice()
        })
    </script>
@endpush