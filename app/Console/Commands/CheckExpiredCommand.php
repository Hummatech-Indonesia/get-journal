<?php

namespace App\Console\Commands;

use App\Contracts\Interfaces\TransactionInterface;
use App\Enums\TransactionEnum;
use App\Models\Transaction;
use Exception;
use Illuminate\Console\Command;

class CheckExpiredCommand extends Command
{
    private TransactionInterface $transaction;

    public function __construct(TransactionInterface $transaction)
    {
        parent::__construct();
        $this->transaction = $transaction;
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check expired transaction';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $transaksi = $this->transaction->getDataExpired([]);
        if(count($transaksi) > 0){
            $transaksi->toQuery()->update(['status' => TransactionEnum::EXPIRED]);
        }
    }
}
