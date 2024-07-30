<?php

namespace App\Contracts\Repositories;

use App\Contracts\Interfaces\AssignmentInterface;
use App\Contracts\Interfaces\TransactionInterface;
use App\Models\Assignment;
use Illuminate\Support\Facades\Storage;

class TransactionRepository extends BaseRepository implements TransactionInterface
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
