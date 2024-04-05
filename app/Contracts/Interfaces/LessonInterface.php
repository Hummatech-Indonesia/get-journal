<?php

namespace App\Contracts\Interfaces;

use App\Contracts\Interfaces\Eloquent\DeleteInterface;
use App\Contracts\Interfaces\Eloquent\ShowInterface;
use App\Contracts\Interfaces\Eloquent\StoreInterface;
use App\Contracts\Interfaces\Eloquent\UpdateInterface;
use App\Contracts\Interfaces\Lesson\GetLessonByClassroomInterface;
use App\Contracts\Interfaces\Lesson\GetLessonByUserInterface;

interface LessonInterface extends GetLessonByClassroomInterface, GetLessonByUserInterface, StoreInterface, UpdateInterface, DeleteInterface, ShowInterface
{
}
