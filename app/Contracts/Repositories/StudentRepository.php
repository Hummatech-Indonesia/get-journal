<?php

namespace App\Contracts\Repositories;

use App\Contracts\Interfaces\StudentInterface;
use App\Models\ClassroomStudent;

class StudentRepository extends BaseRepository implements StudentInterface
{
    public function __construct(ClassroomStudent $classroomStudent)
    {
        $this->model = $classroomStudent;
    }

    /**
     * Get all students by classroom
     *
     * @param mixed $classroom_id
     * @return mixed
     */
    public function getStudentByClassroom(mixed $classroom_id): mixed
    {
        return $this->model->with('student', 'classroom')->where('classroom_id', $classroom_id)->get();
    }

    /**
     * Store a new student
     *
     * @param array $data
     * @return mixed
     */
    public function store(array $data): mixed
    {
        return $this->model->create($data);
    }

    /**
     * Delete a student
     *
     * @param mixed $id
     * @return mixed
     */
    public function delete(mixed $id): mixed
    {
        try {
            $this->model->find($id)->delete();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
