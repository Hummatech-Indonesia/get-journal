<?php

namespace App\Http\Controllers\Api\User;

use App\Contracts\Interfaces\User\ProfileInterface;
use App\Contracts\Interfaces\User\UserInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\UpdatePasswordRequest;
use App\Http\Requests\User\UpdateProfileRequest;
use App\Http\Resources\DefaultResource;
use App\Services\UserService;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    private UserInterface $userInterface;
    private ProfileInterface $profileInterface;
    private UserService $userService;

    public function __construct(UserInterface $userInterface, ProfileInterface $profileInterface, UserService $userService)
    {
        $this->userInterface = $userInterface;
        $this->profileInterface = $profileInterface;
        $this->userService = $userService;
    }

    /**
     * Update password
     *
     * @param UpdatePasswordRequest $request
     * @return mixed
     */
    public function updatePassword(UpdatePasswordRequest $request): mixed
    {
        $data = $request->validated();

        if (Hash::check($data['password'], auth()->user()->password) === false) {
            return DefaultResource::make([
                'code' => 400,
                'message' => 'Password lama tidak sesuai',
            ], 400);
        }

        $this->userInterface->updatePassword(auth()->id(), $data);

        return DefaultResource::make([
            'code' => 200,
            'message' => 'Password berhasil diubah',
        ]);
    }

    /**
     * Update profile
     *
     * @param UpdateProfileRequest $request
     * @return mixed
     */
    public function updateProfile(UpdateProfileRequest $request): mixed
    {
        $data = $request->validated();

        if ($data['email'] != auth()->user()->email) {
            $this->userInterface->update(auth()->id(), ['email' => $data['email']]);
        }

        $profile = $this->userService->handleUpdateProfileWithPhoto($request);
        $this->profileInterface->update(auth()->user()->profile->id, $profile);

        return DefaultResource::make([
            'code' => 200,
            'message' => 'Profile berhasil diubah',
        ]);
    }
}
