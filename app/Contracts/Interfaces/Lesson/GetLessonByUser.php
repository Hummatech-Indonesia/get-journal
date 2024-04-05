<?php

namespace App\Contracts\Interfaces\Lesson;

interface GetLessonByUser
{
    public function getLessonByUser(mixed $profileId): mixed;
}
