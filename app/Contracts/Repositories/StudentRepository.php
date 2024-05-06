<?php

namespace App\Contracts\Repositories;

use App\Contracts\Interfaces\StudentInterface;
use App\Models\ClassroomStudent;
use Illuminate\Support\Facades\DB;

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

    /**
     * Get classroom student by assignment
     *
     * @param string $assignmentId
     * @return mixed
     */
    public function getClassroomStudentByAssignment(string $assignmentId, string $classroomId): mixed
    {
        $query = DB::select("SELECT *, classroom_students.id as classroom_student_id FROM classroom_students INNER JOIN profiles ON classroom_students.student_id = profiles.id LEFT JOIN marks ON classroom_students.id = marks.classroom_student_id WHERE classroom_students.classroom_id = ? AND marks.assignment_id = ? OR marks.assignment_id is null", [$classroomId, $assignmentId]);

        return $this->model->hydrate($query);
    }
}
