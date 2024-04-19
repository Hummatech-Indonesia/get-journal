<?php

namespace App\Contracts\Interfaces\Classrooms;

interface ChangeBackgroundInterface
{
    public function changeBackground(int $classroom_id, int $background_id): mixed;
}
