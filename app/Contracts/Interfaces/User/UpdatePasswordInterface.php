<?php

namespace App\Contracts\Interfaces\User;

interface UpdatePasswordInterface
{
    public function updatePassword(mixed $id, array $data): mixed;
}
