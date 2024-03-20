<?php

namespace App\Contracts\Interfaces\Assignment;

interface MarkAssignmentInterface
{
    public function mark(array $data): void;
}
