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
     * Get backgrounds by status
     */
    public function getByStatus(mixed $is_premium): mixed
    {
        return $this->model->where('is_premium', $is_premium)->get();
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
