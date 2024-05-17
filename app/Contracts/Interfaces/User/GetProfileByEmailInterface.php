<?php

namespace App\Contracts\Interfaces\User;

interface GetProfileByEmailInterface
{
    public function getProfileByEmail(mixed $identityNumber): mixed;
}
