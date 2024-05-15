<?php

namespace App\Contracts\Interfaces;

use App\Contracts\Interfaces\Classrooms\ExportAttendanceInterface;
use App\Contracts\Interfaces\Eloquent\DeleteInterface;
use App\Contracts\Interfaces\Eloquent\StoreInterface;
use App\Contracts\Interfaces\Eloquent\UpdateInterface;
use App\Contracts\Interfaces\Student\GetClassroomStudentByAssignmentInterface;
use App\Contracts\Interfaces\Student\GetStudentByClassroomInterface;

interface StudentInterface extends GetStudentByClassroomInterface, StoreInterface, DeleteInterface, ExportAttendanceInterface
{
}
