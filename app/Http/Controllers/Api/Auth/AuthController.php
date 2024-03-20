<?php

namespace App\Http\Controllers\Api\Auth;

use App\Contracts\Interfaces\AuthInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    private AuthInterface $auth;

    public function __construct(AuthInterface $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle a login request to the application.
     *
     * @param \App\Http\Requests\Auth\LoginRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        return $this->auth->login($request);
    }

    /**
     * Handle a register request to the application.
     *
     * @param \App\Http\Requests\Auth\RegisterRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        return $this->auth->register($request);
    }

    /**
     * Handle a profile request to the application.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function profile(): JsonResponse
    {
        return $this->auth->getUser();
    }

    /**
     * Handle a logout request to the application.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(): JsonResponse
    {
        return $this->auth->logout();
    }
}
