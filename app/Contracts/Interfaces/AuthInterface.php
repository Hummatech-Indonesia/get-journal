<?php

namespace App\Contracts\Interfaces;

use App\Contracts\Interfaces\Auth\GetuserInterface;
use App\Contracts\Interfaces\Auth\LoginInterface;
use App\Contracts\Interfaces\Auth\LogoutInterface;
use App\Contracts\Interfaces\Auth\RegisterInterface;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Http\JsonResponse;

interface AuthInterface extends LogoutInterface, GetuserInterface
{
    public function loginTeacher(LoginRequest $request): JsonResponse;

    public function registerTeacher(RegisterRequest $request): JsonResponse;
}
