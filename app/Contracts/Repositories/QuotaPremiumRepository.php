<?php

namespace App\Contracts\Repositories;

use App\Contracts\Interfaces\QuotaPremiumInterface;
use App\Models\QuotaPremium;
use Illuminate\Support\Facades\Storage;

class QuotaPremiumRepository extends BaseRepository implements QuotaPremiumInterface
{
    public function __construct(QuotaPremium $model)
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
        return $this->model->get();
    }

    public function getWhere(array $data): mixed
    {
        return $this->model->query()
        ->when(count($data) > 0, function ($query) use ($data){
            foreach($data as $index => $value){
                $query->where($index, $value);
            }
        })
        ->first();
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

    public function show(mixed $id):mixed 
    {
        return $this->model->find($id);
    }

    public function update(mixed $data, mixed $id): mixed
    {
        return $this->show($id)->update($data);
    }

    public function customQuery(mixed $data, ?string $order = "asc"): mixed
    {
        return $this->model->query()
        ->where('expired_date','>',date('Y-m-d'));
    }
}
