<?php

namespace App\Contracts\Interfaces\Classrooms;

interface GetAssignmentByClassroom
{
    /**
     * Get all the assignments by classroom id
     * @param mixed $id
     * @return mixed
     */
    public function getAssignmentByClassroom(mixed $id): mixed;
}
