<?php

namespace App\Contracts\Repositories;

use App\Contracts\Interfaces\PaymentChannelInterface;
use App\Models\Assignment;
use Illuminate\Support\Facades\Storage;

class PaymentChannelRepository extends BaseRepository implements PaymentChannelInterface
{
    public function __construct(Assignment $model)
    {
        $this->model = $model;
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
