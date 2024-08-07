<?php

namespace App\Services;

use App\Http\Resources\DefaultResource;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Response;

class TripayService
{
    private string $api_key;
    private string $private_key;
    private string $merchant_code;
    private string $uri;
    private string $merchant_ref;
    private int $expired_time;

    public function __construct()
    {
        $this->api_key = env('TRIPAY_API_KEY') ?? '';
        $this->private_key = env('TRIPAY_PRIVATE_KEY') ?? '';
        $this->merchant_code = env('TRIPAY_MERCHANT') ?? '';
        $this->uri = env("TRIPAY_BASE_URI") ?? '';
        $this->merchant_ref = 'INV_'.date('Ymdhms').'_JM';
        $this->expired_time = env('TRIPAY_EXPIRED_TIME') ?? 1722941158;
    }

    private function generateSignature(string $channel, ?int $amount)
    {
        if(!$amount) $signature = hash_hmac('sha256', $this->merchant_code.$channel.$this->merchant_ref, $this->private_key);
        else $signature = hash_hmac('sha256', $this->merchant_code.$this->merchant_ref.$amount, $this->private_key);

        return $signature;
    }

    public function getPaymentInstruction(array $payload)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->api_key,
        ])->get($this->uri. '/payment/instruction', $payload);

        return json_decode($response->body(), true); 
    }

    public function getPaymentChannel()
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->api_key,
        ])->get($this->uri. '/merchant/payment-channel');

        return json_decode($response->body(), true); 
    }

    /**
    *  page	int	1	
    *  per_page	int	50
    *  sort	string	desc
    *  reference	string	T0001000000455HFGRY	
    *  merchant_ref	string	INV57564
    *  method	string	BRIVA
    *  status string PAID
     */
    public function getTransaction(array $payload)
    {  
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->api_key,
        ])->get($this->uri. '/merchant/transactions', $payload);

        return json_decode($response->body(), true); 
    }

    public function closedTransaction(array $payload)
    {
        $payload["signature"] = $this->generateSignature($payload["method"], $payload["amount"]);
        $payload["merchant_ref"] = $this->merchant_ref;
        $payload['expired_time'] = $payload['expired_time'] ?? $this->expired_time;

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->api_key,
        ])->post($this->uri. '/transaction/create', $payload);

        return json_decode($response->body(), true); 
    }

    public function closedTransactionDetail(string $reference)
    {
        $payload = ['reference'	=> $reference];

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->api_key,
        ])->get($this->uri. '/transaction/detail', $payload);

        return json_decode($response->body(), true); 
    }

    public function closedTransactionCheckStatus(string $reference)
    {
        $payload = ['reference'	=> $reference];

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->api_key,
        ])->get($this->uri. '/transaction/check-status', $payload);

        return json_decode($response->body(), true); 
    }

    public function openTransaction(array $payload)
    {

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->api_key,
        ])->post($this->uri. '/open-payment/create', $payload);

        return json_decode($response->body(), true); 
    }
    
    public function openTransactionDetail(string $uuid)
    {

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->api_key,
        ])->get($this->uri. '/open-payment/'.$uuid.'/detail');

        return json_decode($response->body(), true); 
    }

    public function openTransactionCheckStatus(string $uuid)
    {

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->api_key,
        ])->get($this->uri. '/open-payment/'.$uuid.'/transactions');

        return json_decode($response->body(), true); 
    }

    public function callback(Request $request)
    {
        $callbackSignature = $request->server('HTTP_X_CALLBACK_SIGNATURE');
        $json = $request->getContent();
        $signature = hash_hmac('sha256', $json, $this->private_key);

        if ($signature !== (string) $callbackSignature) {
            return (DefaultResource::make([
                'code' => 500,
                'message' => 'Invalid signature',
                'data' => null
            ]))->response()->setStatusCode(500);
        }

        if ('payment_status' !== (string) $request->server('HTTP_X_CALLBACK_EVENT')) {
            return (DefaultResource::make([
                'code' => 500,
                'message' => 'Unrecognized callback event, no action was taken',
                'data' => null
            ]))->response()->setStatusCode(500);
        }

        $data = json_decode($json);

        if (JSON_ERROR_NONE !== json_last_error()) {
            return (DefaultResource::make([
                'code' => 500,
                'message' => 'Invalid data sent by tripay',
                'data' => null
            ]))->response()->setStatusCode(500);
        }

        $invoiceId = $data->merchant_ref;
        $tripayReference = $data->reference;
        $status = strtoupper((string) $data->status);

        if ($data->is_closed_payment === 1) {
            $invoice = Transaction::where('merchant_ref', $invoiceId)
                ->where('reference', $tripayReference)
                ->where('status', '=', 'UNPAID')
                ->first();

            if (! $invoice) {
                return (DefaultResource::make([
                    'code' => 500,
                    'message' => 'No invoice found or already paid: ' . $invoiceId,
                    'data' => null
                ]))->response()->setStatusCode(500);
            }

            switch ($status) {
                case 'PAID':
                    $invoice->update(['status' => 'PAID']);
                    break;

                case 'EXPIRED':
                    $invoice->update(['status' => 'EXPIRED']);
                    break;

                case 'FAILED':
                    $invoice->update(['status' => 'FAILED']);
                    break;

                default:
                    return (DefaultResource::make([
                        'code' => 500,
                        'message' => 'Unrecognized payment status',
                        'data' => null
                    ]))->response()->setStatusCode(500);
            }

            return (DefaultResource::make([
                'code' => 200,
                'message' => 'Berhasil melakukan callback pembayaran',
                'data' => null
            ]))->response()->setStatusCode(200);
        }
    }
}
