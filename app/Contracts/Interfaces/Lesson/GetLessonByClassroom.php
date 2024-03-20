<?php

namespace App\Contracts\Interfaces\Lesson;

interface GetLessonByClassroom
{
    public function get(mixed $classroomId): mixed;
}
