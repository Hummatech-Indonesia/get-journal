<?php

namespace App\Contracts\Interfaces\Student;

interface GetStudentByClassroomInterface
{
    public function getStudentByClassroom(mixed $classroomId): mixed;
}
