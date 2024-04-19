<?php

namespace App\Contracts\Repositories;

use App\Contracts\Interfaces\BackgroundInterface;
use App\Models\Background;

class BackgroundRepository extends BaseRepository implements BackgroundInterface
{
    public function __construct(Background $model)
    {
        $this->model = $model;
    }

    /**
     * Get all backgrounds
     */
    public function get(): mixed
    {
        return $this->model->get();
    }

    /**
     * Store a new background
     */
    public function store(array $data): mixed
    {
        return $this->model->create($data);
    }

    /**
     * Update a specific background
     */

    public function update(mixed $id, array $data): mixed
    {
        return $this->model->find($id)->update($data);
    }

    /**
     * Delete a specific background
     */
    public function delete(mixed $id): mixed
    {
        try {
            $this->model->find($id)->delete();

            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
}
