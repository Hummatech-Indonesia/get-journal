<?php

namespace App\Contracts\Interfaces;

use App\Contracts\Interfaces\Classrooms\GenerateCodeInterface;
use App\Contracts\Interfaces\Eloquent\DeleteInterface;
use App\Contracts\Interfaces\Eloquent\GetInterface;
use App\Contracts\Interfaces\Eloquent\ShowInterface;
use App\Contracts\Interfaces\Eloquent\StoreInterface;
use App\Contracts\Interfaces\Eloquent\UpdateInterface;

interface ClassroomInterface extends GetInterface, ShowInterface, StoreInterface, UpdateInterface, DeleteInterface, GenerateCodeInterface
{
}
