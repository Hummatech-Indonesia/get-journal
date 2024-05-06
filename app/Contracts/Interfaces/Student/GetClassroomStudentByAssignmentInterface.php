<?php

namespace App\Contracts\Interfaces\Student;

interface GetClassroomStudentByAssignmentInterface
{
    public function getClassroomStudentByAssignment(string $assignmentId, string $classroomId): mixed;
}
