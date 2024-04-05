<?php

namespace App\Contracts\Interfaces;

use App\Contracts\Interfaces\Classrooms\GenerateCodeInterface;
use App\Contracts\Interfaces\Classrooms\GetClassroomByUser;
use App\Contracts\Interfaces\Eloquent\DeleteInterface;
use App\Contracts\Interfaces\Eloquent\ShowInterface;
use App\Contracts\Interfaces\Eloquent\StoreInterface;
use App\Contracts\Interfaces\Eloquent\UpdateInterface;

interface ClassroomInterface extends GetClassroomByUser, ShowInterface, StoreInterface, UpdateInterface, DeleteInterface, GenerateCodeInterface
{
}
