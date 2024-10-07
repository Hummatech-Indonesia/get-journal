<?php

namespace App\Contracts\Interfaces\Assignment;

use App\Contracts\Interfaces\Eloquent\StoreInterface;
use App\Contracts\Interfaces\Student\GetClassroomStudentByAssignmentInterface;

interface MarkAssignmentInterface extends StoreInterface, GetClassroomStudentByAssignmentInterface, DeleteMarkByStudentInterface
{
    public function mark(array $data): void;
    
    public function customQuery(array $data): mixed;
}
