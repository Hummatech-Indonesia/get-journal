<?php

namespace App\Contracts\Interfaces;

use App\Contracts\Interfaces\Classrooms\ChangeBackgroundInterface;
use App\Contracts\Interfaces\Classrooms\GenerateCodeInterface;
use App\Contracts\Interfaces\Classrooms\GetAssignmentByClassroom;
use App\Contracts\Interfaces\Classrooms\GetClassroomByUserInterface;
use App\Contracts\Interfaces\Eloquent\DeleteInterface;
use App\Contracts\Interfaces\Eloquent\ShowInterface;
use App\Contracts\Interfaces\Eloquent\StoreInterface;
use App\Contracts\Interfaces\Eloquent\UpdateInterface;

interface ClassroomInterface extends GetClassroomByUserInterface, GetAssignmentByClassroom, ShowInterface, StoreInterface, UpdateInterface, DeleteInterface, GenerateCodeInterface, ChangeBackgroundInterface
{
}
