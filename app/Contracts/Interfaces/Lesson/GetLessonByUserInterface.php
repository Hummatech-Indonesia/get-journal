<?php

namespace App\Contracts\Interfaces\Lesson;

interface GetLessonByUserInterface
{
    public function getLessonByUser(mixed $profileId): mixed;
}
