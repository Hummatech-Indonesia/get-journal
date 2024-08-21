<?php

namespace App\Http\Controllers;

use App\Contracts\Interfaces\PaymentChannelInterface;
use App\Contracts\Interfaces\TransactionInterface;
use App\Contracts\Interfaces\User\UserInterface;
use App\Helpers\BaseDatatable;
use App\Http\Requests\Payment\ClosedTransactionRequest;
use App\Http\Resources\DefaultResource;
use App\Services\TripayService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    private TripayService $tripayService;
    private PaymentChannelInterface $paymentChannel;
    private TransactionInterface $transaction;
    private UserInterface $user;

    public function __construct(TripayService $tripayService, PaymentChannelInterface $paymentChannel,
    TransactionInterface $transaction, UserInterface $user)
    {
        $this->tripayService = $tripayService;
        $this->paymentChannel = $paymentChannel;
        $this->transaction = $transaction;
        $this->user = $user;
    }

    public function instruction(Request $request)
    {
        if(!$request->code) return (DefaultResource::make([
            'code' => 400,
            'message' => 'Field "code" harus diisi ',
        ]))->response()->setStatusCode(400);
        
        $data = $this->tripayService->getPaymentInstruction([
            "code" => $request->code,
            "pay_code" => $request->pay_code ?? "-"
        ]);
        
        if($data["success"]){
            return (DefaultResource::make([
                'code' => 200,
                'message' => 'Berhasil mengambil instruksi pembayaran',
                'data' => $data["data"]
            ]))->response()->setStatusCode(200);
        }else {
            return (DefaultResource::make([
                'code' => 500,
                'message' => $data["message"] ?? "Invalid payment instruction",
                'data' => null
            ]))->response()->setStatusCode(500);
        }
    
    }

    public function paymentChannel(Request $request)
    {
        try{
            $data = $this->paymentChannel->get();

            return (DefaultResource::make([
                'code' => 200,
                'message' => 'Berhasil mengambil channel pembayaran',
                'data' => $data
            ]))->response()->setStatusCode(200);
        }catch(\Throwable $th){

            return (DefaultResource::make([
                'code' => 500,
                'message' => 'Invalid dalam mengambil data channel pembayaran dikarekanakn => '. $th->getMessage(),
                'data' => []
            ]))->response()->setStatusCode(500);
        }
    }

    public function listTransaction(Request $request)
    {
        try{
            $payload = [
                "page" => $request->page ?? 1,
                "per_page" => $request->per_page ?? 10,
                "sort" => $request->sort ?? "desc"
            ];
    
            if($request->reference) $payload["reference"] = $request->reference;
            if($request->merchant_ref) $payload["merchant_ref"] = $request->merchant_ref;
            if($request->method) $payload["method"] = $request->method;
            if($request->status) $payload["status"] = $request->status;
    
            $data = $this->tripayService->getPaymentInstruction($payload);
            
            if($data["success"]){
                return (DefaultResource::make([
                    'code' => 200,
                    'message' => 'Berhasil mengambil instruksi pembayaran',
                    'data' => [
                        "pagination" => $data["pagination"],
                        "data" => $data["data"]
                    ]
                ]))->response()->setStatusCode(200);
            }else {
                return (DefaultResource::make([
                    'code' => 500,
                    'message' => $data["message"] ?? "Invalid payment instruction",
                    'data' => null
                ]))->response()->setStatusCode(500);
            }
        }catch(\Throwable $th){
            return (DefaultResource::make([
                'code' => 500,
                'message' => $th->getMessage(),
                'data' => null
            ]))->response()->setStatusCode(500);
        }
    }
    
    public function listTransactionV2(Request $request)
    {
        try{
            $data = $this->transaction->getWhere($request->all());
            
            return BaseDatatable::TableV2($data->toArray());
        }catch(\Throwable $th) {
            return (DefaultResource::make([
                'code' => 500,
                'message' => $th->getMessage(),
                'data' => null
            ]))->response()->setStatusCode(500);
        }
    }

    public function listTransactionV3(Request $request)
    {
        try{
            $per_page = ($requestt->per_page ?? 10);
            $page = ($requestt->page ?? 1);

            $data = $this->transaction->customPaginateV2($request, $per_page, $page);
            
            return (DefaultResource::make([
                'code' => 200,
                'message' => 'Berhasil mengambil instruksi pembayaran',
                'data' => $data
            ]))->response()->setStatusCode(200);
        }catch(\Throwable $th) {
            return (DefaultResource::make([
                'code' => 500,
                'message' => $th->getMessage(),
                'data' => null
            ]))->response()->setStatusCode(500);
        }
    }

    public function closedTransaction(ClosedTransactionRequest $request)
    {
        try{
            $result = $this->tripayService->closedTransaction($request->all());
            
            if($result["success"]){
                $user = $this->user->getWhere(['email' => $result['data']['customer_email']]);

                $result['data']['user_id'] = auth()->user()->id ?? $user->id;
                $result['data']['expired_time'] = date('Y-m-d H:m:s', $result['data']['expired_time']);
                $result['data']['order_items'] = json_encode($result['data']['order_items']);
                $result['data']['instructions'] = json_encode($result['data']['instructions']);
                
                $this->transaction->store($result['data']);

                if($request->app_type == 'web'){
                    return redirect()->route('transactions.show',['reference' => $result['data']['merchant_ref']])->with(['success' => 'Transaksi berhasil dibuat, silahkan melakukan pembayaran!', 'checkout' => true]);
                } else {
                    return (DefaultResource::make([
                        'code' => 200,
                        'message' => 'Berhasil membuat pembayaran',
                        'data' => $result['data']
                    ]))->response()->setStatusCode(200);
                }
            }else {
                if($request->app_type == 'web'){
                    return redirect()->back()->with('error', $result['message']);
                } else {
                    return (DefaultResource::make([
                        'code' => 500,
                        'message' => $result["message"] ?? "Invalid api",
                        'data' => null
                    ]))->response()->setStatusCode(500);
                }
            }
        }catch(\Throwable $th) {
            if($request->app_type == 'web'){
                return redirect()->back()->with('error', $th->getMessage());
            } else {
                return (DefaultResource::make([
                    'code' => 500,
                    'message' => $th->getMessage(),
                    'data' => null
                ]))->response()->setStatusCode(500);
            }
        }
    }

    public function callbackTransaction(Request $request)
    {
        return $this->tripayService->callback($request);   
    }

    public function checkStatusTransaction(Request $request)
    {
        if(!$request->reference) return (DefaultResource::make([
            'code' => 400,
            'message' => 'Field "reference" harus di isi',
            'data' => null
        ]))->response()->setStatusCode(400);

        $result = $this->tripayService->closedTransactionCheckStatus($request->reference);
        if($result["success"]){
            return (DefaultResource::make([
                'code' => 200,
                'message' => 'Berhasil mengambil instruksi pembayaran',
                'data' => $result["data"]
            ]))->response()->setStatusCode(200);
        }else {
            return (DefaultResource::make([
                'code' => 500,
                'message' => $result["message"] ?? "Failed check status",
                'data' => null
            ]))->response()->setStatusCode(500);
        }
    }

    public function detailClosedTransaction(mixed $merchant_reference)
    {
        $data = $this->transaction->getWhere(["merchant_ref" => $merchant_reference]);
        if(count($data) == 0){
            abort(404);
        }else {
            return view('pages.users.transactions.detail',compact(["data" => $data[0]]));
        }
    }

    public function detailClosedTransactionMobile(mixed $merchant_reference)
    {
        $data = $this->transaction->getWhere(["merchant_ref" => $merchant_reference]);
        if(count($data) == 0){
            return (DefaultResource::make([
                'code' => 404,
                'message' => "Detail transaksi tidak ditemukan",
                'data' => null
            ]))->response()->setStatusCode(404);
        }else {
            return (DefaultResource::make([
                'code' => 200,
                'message' => 'Berhasil mengambil detail transaksi',
                'data' => $data[0]
            ]))->response()->setStatusCode(200);
        }
    }
}
