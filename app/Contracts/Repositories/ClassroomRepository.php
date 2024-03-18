<?php

namespace App\Contracts\Repositories;

use App\Contracts\Interfaces\ClassroomInterface;
use App\Models\Classroom;

class ClassroomRepository extends BaseRepository implements ClassroomInterface
{

    public function __construct(Classroom $model)
    {
        $this->model = $model;
    }

    /**
     * Get all classrooms
     */
    public function get(): mixed
    {
        return $this->model->all();
    }

    /**
     * Get a specific classroom
     */
    public function show(mixed $id): mixed
    {
        return $this->model->find($id);
    }

    /**
     * Store a new classroom
     */
    public function store(array $data): mixed
    {
        return $this->model->create($data);
    }

    /**
     * Update a specific classroom
     */
    public function update(mixed $id, array $data): mixed
    {
        return $this->model->find($id)->update($data);
    }

    /**
     * Delete a specific classroom
     */
    public function delete(mixed $id): mixed
    {
        return $this->model->find($id)->delete();
    }
}
