<?php

namespace App\Contracts\Repositories;

use App\Contracts\Interfaces\AssignmentInterface;
use App\Models\Assignment;
use Illuminate\Support\Facades\Storage;

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

    /**
     * Export marks
     * @param mixed $assignmentId
     * @return mixed
     */
    public function exportMarks(mixed $assignmentId): mixed
    {
        return $this->model
            ->with('marks.classroomStudent.student', 'lesson.classroom')
            ->where('id', $assignmentId)
            ->first();
    }

    /**
     * Delete export marks
     * @param string $path
     * @return mixed
     */
    public function deleteExportMarks(string $path): mixed
    {
        if (Storage::exists($path)) {
            Storage::delete($path);
            return true;
        }

        return false;
    }

    public function customQuery(array $ids): mixed
    {
        return $this->model
            ->with('marks', 'lesson')
            ->whereIn('lesson_id', $ids);
    }
}
