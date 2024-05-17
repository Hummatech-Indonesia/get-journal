<?php

namespace App\Contracts\Interfaces\User;

use App\Contracts\Interfaces\Eloquent\DeleteInterface;
use App\Contracts\Interfaces\Eloquent\StoreInterface;
use App\Contracts\Interfaces\Eloquent\UpdateInterface;

interface UserInterface extends StoreInterface, UpdatePasswordInterface, UpdateInterface, DeleteInterface
{
}
