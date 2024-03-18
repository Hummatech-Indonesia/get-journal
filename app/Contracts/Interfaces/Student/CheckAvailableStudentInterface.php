<?php

namespace App\Contracts\Interfaces\Student;

interface CheckAvailableStudentInterface
{
    public function checkAvailableStudent(mixed $identityNumber): mixed;
}
