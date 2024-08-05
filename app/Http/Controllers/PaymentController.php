<?php

namespace App\Http\Controllers;

use App\Contracts\Interfaces\PaymentChannelInterface;
use App\Contracts\Interfaces\TransactionInterface;
use App\Helpers\BaseDatatable;
use App\Http\Resources\DefaultResource;
use App\Services\TripayService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    private TripayService $tripayService;
    private PaymentChannelInterface $paymentChannel;
    private TransactionInterface $transaction;

    public function __construct(TripayService $tripayService, PaymentChannelInterface $paymentChannel,
    TransactionInterface $transaction)
    {
        $this->tripayService = $tripayService;
        $this->paymentChannel = $paymentChannel;
        $this->transaction = $transaction;
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
            $data = $this->tripayService->getPaymentChannel();
    
            if($data["success"]){
                return (DefaultResource::make([
                    'code' => 200,
                    'message' => 'Berhasil mengambil channel pembayaran',
                    'data' => $data["data"]
                ]))->response()->setStatusCode(200);
            }else {
                return (DefaultResource::make([
                    'code' => 500,
                    'message' => $data["message"] ?? "Invalid api",
                    'data' => null
                ]))->response()->setStatusCode(500);
            }
        }catch(\Throwable $th){
            $data = $this->paymentChannel->get();

            return (DefaultResource::make([
                'code' => 200,
                'message' => 'Berhasil mengambil channel pembayaran',
                'data' => $data
            ]))->response()->setStatusCode(200);
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
            // $data = $this->transaction->customPaginate($request, 10);
            
            return (DefaultResource::make([
                'code' => 200,
                'message' => 'Berhasil mengambil instruksi pembayaran',
                'data' => []
            ]))->response()->setStatusCode(200);
        }catch(\Throwable $th) {
            return (DefaultResource::make([
                'code' => 500,
                'message' => $th->getMessage(),
                'data' => null
            ]))->response()->setStatusCode(500);
        }
    }
}
