<?php

namespace App\Contracts\Interfaces\Lesson;

interface GetLessonByClassroomInterface
{
    public function get(mixed $classroomId): mixed;
}
