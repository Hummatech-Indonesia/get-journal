<?php

namespace App\Contracts\Interfaces\Auth;

use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Http\JsonResponse;

interface RegisterInterface
{
    /**
     * Handle a register request to the application.
     *
     * @param \App\Http\Requests\Api\Auth\RegisterRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function register(RegisterRequest $request): JsonResponse;
}
