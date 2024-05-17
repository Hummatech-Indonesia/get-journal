<?php

namespace App\Services;

use App\Contracts\Interfaces\Assignment\MarkAssignmentInterface;

class StudentService
{

    private MarkAssignmentInterface $mark;

    public function __construct(MarkAssignmentInterface $mark)
    {
        $this->mark = $mark;
    }

    /**
     * Create mark for new student
     * @param int $classroomStudentId
     * @param mixed $assignments
     * @return mixed
     */
    public function createMarkNewStudent(int $classroomStudentId, mixed $assignments): void
    {
        foreach ($assignments as $assignment) {
            $data = [
                'classroom_student_id' => $classroomStudentId,
                'assignment_id' => $assignment->id,
            ];
            $this->mark->store($data);
        }
    }
}
