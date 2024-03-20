<?php

namespace App\Contracts\Interfaces\Auth;

use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\JsonResponse;

interface LoginInterface
{
    /**
     * Handle a login request to the application.
     *
     * @param \App\Http\Requests\Auth\LoginRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function login(LoginRequest $request): JsonResponse;
}
