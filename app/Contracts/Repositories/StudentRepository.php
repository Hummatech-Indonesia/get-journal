<?php

namespace App\Contracts\Repositories;

use App\Contracts\Interfaces\StudentInterface;
use App\Models\ClassroomStudent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
        return $this->model->with('student.user', 'classroom')->where('classroom_id', $classroom_id)->get();
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

    /**
     * Export attendance
     *
     * @param mixed $classroom_id
     * @return mixed
     */
    public function exportAttendance(mixed $classroom_id): mixed
    {
        return $this->model
            ->with('student.sick', 'student.permit', 'student.alpha', 'classroom')
            ->where('classroom_id', $classroom_id)
            ->get();
    }

    /**
     * Delete exported attendance
     *
     * @param string $path
     * @return mixed
     */
    public function deleteExportedAttendance(string $path): mixed
    {
        if (Storage::exists($path)) {
            Storage::delete($path);
            return true;
        }

        return false;
    }
}
