<?php

namespace App\Contracts\Interfaces\User;

use App\Contracts\Interfaces\Eloquent\ShowInterface;
use App\Contracts\Interfaces\Eloquent\StoreInterface;
use App\Contracts\Interfaces\Eloquent\UpdateInterface;
use App\Contracts\Interfaces\Student\CheckAvailableStudentInterface;

interface ProfileInterface extends GetUserInfoInterface, GetProfileByEmailInterface, StoreInterface, CheckAvailableStudentInterface, UpdateInterface
{
}
