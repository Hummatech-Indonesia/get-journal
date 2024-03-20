<?php

namespace App\Contracts\Repositories;

use App\Contracts\Interfaces\LessonInterface;
use App\Models\Lesson;

class LessonRepository extends BaseRepository implements LessonInterface
{
    public function __construct(Lesson $model)
    {
        $this->model = $model;
    }

    /**
     * Get all lessons
     */
    public function get(mixed $classroom_id): mixed
    {
        return $this->model->where('classroom_id', $classroom_id)->get();
    }

    /**
     * Insert lesson
     */
    public function store($data): mixed
    {
        return $this->model->create($data);
    }

    /**
     * Update lesson
     */
    public function update($id, $data): mixed
    {
        return $this->model->find($id)->update($data);
    }

    /**
     * Delete lesson
     */
    public function delete($id): mixed
    {
        try {
            $this->model->find($id)->delete();
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
}
