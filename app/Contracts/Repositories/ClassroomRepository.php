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
        return $this->model->withCount('students')->get();
    }

    /**
     * Get a specific classroom
     */
    public function show(mixed $id): mixed
    {
        return $this->model->withCount('students')->where('id', $id)->first();
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
        try {
            $this->model->find($id)->delete();

            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    /**
     * Generate code
     */
    public function generateCode(String $code, mixed $id): mixed
    {
        return $this->model->find($id)->update(['code' => $code]);
    }
}
