<?php

namespace App\Contracts\Interfaces\Auth;

use App\Http\Requests\Api\Auth\LoginRequest;
use Illuminate\Http\JsonResponse;

interface GetuserInterface
{

    /**
     * Handle a get user request to the application.
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function getUser(): JsonResponse;
}
