<?php

namespace App\Http\Controllers;

use App\Contracts\Interfaces\PaymentChannelInterface;
use App\Http\Resources\DefaultResource;
use App\Services\TripayService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    private TripayService $tripayService;
    private PaymentChannelInterface $paymentChannel;

    public function __construct(TripayService $tripayService, PaymentChannelInterface $paymentChannel)
    {
        $this->tripayService = $tripayService;
        $this->paymentChannel = $paymentChannel;
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
}
