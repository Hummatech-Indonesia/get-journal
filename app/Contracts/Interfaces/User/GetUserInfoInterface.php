<?php

namespace App\Contracts\Interfaces\User;

interface GetUserInfoInterface
{
    public function getUserInfo(mixed $profileId): mixed;
}
