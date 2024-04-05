<?php

namespace App\Contracts\Interfaces\Classrooms;

interface GetClassroomByUser
{
    public function getClassroomByUser(mixed $profileId): mixed;
}
