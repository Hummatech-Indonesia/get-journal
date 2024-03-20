<?php

namespace App\Contracts\Repositories;

use App\Contracts\Interfaces\AssignmentInterface;
use App\Models\Assignment;

class AssignmentRepository extends BaseRepository implements AssignmentInterface
{
    public function __construct(Assignment $model)
    {
        $this->model = $model;
    }

    /**
     * Get all the assignments by lesson id
     * @param mixed $id
     * @return mixed
     */
    public function get(mixed $id): mixed
    {
        return $this->model->where('lesson_id', $id)->get();
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

    /**
     * Display the specified resource.
     * @param mixed $id
     * @return mixed
     */
    public function show(mixed $id): mixed
    {
        return $this->model->find($id);
    }

    /**
     * Update the specified resource in storage.
     * @param mixed $id
     * @param array $data
     * @return mixed
     */
    public function update(mixed $id, array $data): mixed
    {
        return $this->model->where('id', $id)->update($data);
    }

    /**
     * Remove the specified resource from storage.
     * @param mixed $id
     * @return mixed
     */
    public function delete($id): mixed
    {
        try {
            $this->model->where('id', $id)->delete();
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
}
