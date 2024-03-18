<?php

namespace App\Contracts\Interfaces\User;

interface GetProfileByIdentityNumberInterface
{
    public function getProfileByIdentityNumber(mixed $identityNumber): mixed;
}
