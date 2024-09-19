<?php

namespace App\Http\Controllers\Api\Auth;

use App\Contracts\Interfaces\AuthInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\DefaultResource;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private AuthInterface $auth;
    private UserService $userService;

    public function __construct(AuthInterface $auth, UserService $userService)
    {
        $this->auth = $auth;
        $this->userService = $userService;
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
            return $this->auth->registerSchool($request);
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

    /**
     * Handle a forgot password request to the application mobile.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function forgotPasswordMobile(Request $request): JsonResponse
    {
        $check_email = $this->auth->checkEmail($request->email);
        if($check_email) {
            return (DefaultResource::make(['code' => 404, 'message' => 'Email tidak terdaftar, silahkan check ulang!']))->response()->setStatusCode(404);
        }

        return $this->userService->handleSendEmail($request->email, 'mobile');
    }
    /**
     * Handle a forgot password request to the application.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function forgotPasswordWeb(Request $request): RedirectResponse
    {
        $check_email = $this->auth->checkEmail($request->email);
        if($check_email) {
            return redirect()->back()->with('error', 'Email tidak terdaftar, silahkan check ulang!');
        }

        return $this->userService->handleSendEmail($request->email);
    }
}
