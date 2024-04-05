<?php

namespace App\Contracts\Interfaces;

use App\Contracts\Interfaces\Eloquent\DeleteInterface;
use App\Contracts\Interfaces\Eloquent\GetInterface;
use App\Contracts\Interfaces\Eloquent\ShowInterface;
use App\Contracts\Interfaces\Eloquent\StoreInterface;
use App\Contracts\Interfaces\Eloquent\UpdateInterface;
use App\Contracts\Interfaces\Lesson\GetLessonByClassroom;
use App\Contracts\Interfaces\Lesson\GetLessonByUser;

interface LessonInterface extends GetLessonByClassroom, GetLessonByUser, StoreInterface, UpdateInterface, DeleteInterface, ShowInterface
{
}
