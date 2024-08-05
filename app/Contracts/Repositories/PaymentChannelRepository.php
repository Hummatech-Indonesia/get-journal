<?php

namespace App\Contracts\Repositories;

use App\Contracts\Interfaces\PaymentChannelInterface;
use App\Models\Assignment;
use App\Models\PaymentChannel;
use Illuminate\Support\Facades\Storage;

class PaymentChannelRepository extends BaseRepository implements PaymentChannelInterface
{
    public function __construct(PaymentChannel $model)
    {
        $this->model = $model;
    }

    /**
     * get data for this model.
     * @param array $data
     * @return mixed
     */
    public function get(): mixed
    {
        return $this->model->where('is_delete',0)->get();
    }

    /**
     * Store a newly created resource in storage.
     * @param array $data
     * @return mixed
     */
    public function store(array $data): mixed
    {
        return $this->model->create($data);
    }
}
