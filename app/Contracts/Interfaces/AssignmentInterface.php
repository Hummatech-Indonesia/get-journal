<?php

namespace App\Contracts\Interfaces;

use App\Contracts\Interfaces\Assignment\ExportMarkInterface;
use App\Contracts\Interfaces\Assignment\GetByClassroomInterface;
use App\Contracts\Interfaces\Assignment\GetByLessonInterface;
use App\Contracts\Interfaces\Eloquent\DeleteInterface;
use App\Contracts\Interfaces\Eloquent\ShowInterface;
use App\Contracts\Interfaces\Eloquent\StoreInterface;
use App\Contracts\Interfaces\Eloquent\UpdateInterface;

interface AssignmentInterface extends GetByLessonInterface, StoreInterface, ShowInterface, UpdateInterface, DeleteInterface, ExportMarkInterface
{
    public function customQuery(array $ids): mixed;
}
