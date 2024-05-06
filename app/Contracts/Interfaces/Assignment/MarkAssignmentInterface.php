<?php

namespace App\Contracts\Interfaces\Assignment;

use App\Contracts\Interfaces\Eloquent\StoreInterface;

interface MarkAssignmentInterface extends StoreInterface
{
    public function mark(array $data): void;
}
