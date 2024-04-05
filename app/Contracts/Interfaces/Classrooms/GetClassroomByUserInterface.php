<?php

namespace App\Contracts\Interfaces\Classrooms;

interface GetClassroomByUserInterface
{
    public function getClassroomByUser(mixed $profileId): mixed;
}
