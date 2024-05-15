<?php

namespace App\Contracts\Repositories;

use App\Contracts\Interfaces\AuthInterface;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\Auth\ProfileResource;
use App\Http\Resources\Auth\UserResource;
use App\Http\Resources\DefaultResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class AuthRepository extends BaseRepository implements AuthInterface
{
    public function __construct(User $model)
    {
        $this->model = $model;
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
        $credentials = $request->validated();

        if (auth()->attempt($credentials)) {
            $token = auth()->user()->createToken('authToken')->plainTextToken;
            $user = $this->model->with('profile')->find(auth()->user()->id);
            $user->token = $token;

            if ($user->roles->pluck('name')[0] != 'teacher') {
                return (DefaultResource::make(['code' => 401, 'message' => 'Unauthorized']))->response()->setStatusCode(401);
            }

            return (UserResource::make($user))->response()->setStatusCode(200);
        }

        return (DefaultResource::make(['code' => 401, 'message' => 'Unauthorized']))->response()->setStatusCode(401);
    }

    /**
     * Handle a profile request to the application.
     *
     * @param \App\Http\Requests\Auth\RegisterRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function registerTeacher(RegisterRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['is_register'] = 1;

        $user = $this->model->create([
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
        $data['user_id'] = $user->id;
        $profile = $user->profile()->create($data);
        $user->assignRole('teacher');

        return (DefaultResource::make(['code' => 200, 'message' => 'Berhasil mendaftarkan pengguna', 'profile' => $profile]))->response()->setStatusCode(200);
    }

    /**
     * Handle a profile request to the application.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(): JsonResponse
    {
        auth()->user()->tokens()->delete();

        return (DefaultResource::make(['code' => 200, 'message' => 'Successfully logged out']))->response()->setStatusCode(200);
    }

    /**
     * Handle a profile request to the application.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUser(): JsonResponse
    {
        $profile = auth()->user()->profile;
        $profile['email'] = auth()->user()->email;

        return (ProfileResource::make($profile)->response())->setStatusCode(200);
    }
} {
}
