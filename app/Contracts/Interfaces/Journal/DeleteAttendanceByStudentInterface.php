<?php

namespace App\Contracts\Interfaces\Journal;

interface DeleteAttendanceByStudentInterface
{
    public function deleteAttendanceByStudent(mixed $studentId, mixed $classroomId): mixed;
}
