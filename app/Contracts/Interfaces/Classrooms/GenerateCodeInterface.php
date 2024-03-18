<?php

namespace App\Contracts\Interfaces\Classrooms;

interface GenerateCodeInterface
{
    public function generateCode(String $code, mixed $id): mixed;
}
