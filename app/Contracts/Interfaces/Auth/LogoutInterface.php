<?php

namespace App\Contracts\Interfaces\Auth;

use App\Http\Requests\Api\Auth\LoginRequest;
use Illuminate\Http\JsonResponse;

interface LogoutInterface
{
    /**
     * Handle a logout request to the application.
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function logout(): JsonResponse;
}
