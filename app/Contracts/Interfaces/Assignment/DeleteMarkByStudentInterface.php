<?php

namespace App\Contracts\Interfaces\Assignment;

interface DeleteMarkByStudentInterface
{
    /**
     * Delete mark by student
     * @param mixed $id
     * @return mixed
     */
    public function deleteMarkByStudent(mixed $classroomStudentId): mixed;
}
