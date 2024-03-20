<?php

namespace App\Http\Controllers\Api\User;

use App\Contracts\Interfaces\User\UserInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\UpdatePasswordRequest;
use App\Http\Resources\DefaultResource;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    private UserInterface $userInterface;

    public function __construct(UserInterface $userInterface)
    {
        $this->userInterface = $userInterface;
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
}
