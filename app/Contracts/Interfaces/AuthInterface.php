<?php

namespace App\Contracts\Interfaces;

use App\Contracts\Interfaces\Auth\GetuserInterface;
use App\Contracts\Interfaces\Auth\LoginInterface;
use App\Contracts\Interfaces\Auth\LogoutInterface;
use App\Contracts\Interfaces\Auth\RegisterInterface;

interface AuthInterface extends LoginInterface, RegisterInterface, LogoutInterface, GetuserInterface
{
}
