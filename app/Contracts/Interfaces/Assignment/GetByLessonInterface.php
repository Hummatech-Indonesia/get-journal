<?php

namespace App\Contracts\Interfaces\Assignment;

interface GetByLessonInterface
{
    public function get(mixed $lessonId): mixed;
}
