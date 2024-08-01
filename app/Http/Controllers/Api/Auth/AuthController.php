<?php

namespace App\Http\Controllers\Api\Auth;

use App\Contracts\Interfaces\AuthInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

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
    public function loginTeacher(LoginRequest $request): JsonResponse
    {
        return $this->auth->loginTeacher($request);
    }

    /**
     * Handle a register request to the application.
     *
     * @param \App\Http\Requests\Auth\RegisterRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function registerTeacher(RegisterRequest $request): JsonResponse|RedirectResponse
    {
        if($request->type == "school") {
            $this->auth->registerSchool($request);
            return redirect('login')->with('success','Berhasil membuat akun sekolah');
        }
        else return $this->auth->registerTeacher($request);
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
    public function logout(Request $request): JsonResponse|RedirectResponse
    {
        if($request->type == "web"){
            auth()->logout();
            return redirect('login')->with('success','Berhasil logout');
        }else return $this->auth->logout();
    }
}
