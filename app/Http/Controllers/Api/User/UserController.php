<?php

namespace App\Http\Controllers\Api\User;

use App\Contracts\Interfaces\User\AssignTeacherToSchoolInterface;
use App\Contracts\Interfaces\User\ProfileInterface;
use App\Contracts\Interfaces\User\UserInterface;
use App\Helpers\BaseDatatable;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\AssignTeacherRequest;
use App\Http\Requests\User\UpdatePasswordRequest;
use App\Http\Requests\User\UpdateProfileRequest;
use App\Http\Resources\Auth\UserResource;
use App\Http\Resources\DefaultResource;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    private UserInterface $userInterface;
    private ProfileInterface $profileInterface;
    private UserService $userService;
    private AssignTeacherToSchoolInterface $assignTeacher;

    public function __construct(UserInterface $userInterface, ProfileInterface $profileInterface, UserService $userService,
    AssignTeacherToSchoolInterface $assignTeacher)
    {
        $this->userInterface = $userInterface;
        $this->profileInterface = $profileInterface;
        $this->userService = $userService;
        $this->assignTeacher = $assignTeacher;
    }

    /**
     * Get user info
     *
     * @return mixed
     */
    public function getUserInfo(): mixed
    {
        $profile = $this->profileInterface->getUserInfo(auth()->user()->profile->id);

        return DefaultResource::make($profile)->response()->setStatusCode(200);
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


    /**
     * Assign Teacher to School
     *
     * @param UpdateProfileRequest $request
     * @return mixed
     */
    public function assignTeacher(AssignTeacherRequest $request): mixed
    {
        $user = $this->userInterface->show($request->user_id);
        
        if(!$user) {
            return (DefaultResource::make([
                'code' => 404,
                'message' => 'User tidak ditemukan',
            ]))->response()->setStatusCode(404);
        }

        $data = $request->validated();
        
        try{
            $data['related_code'] = $data["code"];
            if($data["user_id"] == "-") $data['user_id'] = $user->id;
            unset($data["code"]);
            
            $check = $this->assignTeacher->getWhere(["user_id" => $user->id, "related_code" => $data["related_code"]]);
            
            if($check){
                return (DefaultResource::make([
                    'code' => 201,
                    'message' => 'Guru telah masuk ke dalam sekolah ini',
                ]))->response()->setStatusCode(201);
            }
    
            $this->assignTeacher->store($data);
    
            return (DefaultResource::make([
                'code' => 200,
                'message' => 'Berhasil menugaskan guru ke sekolah',
            ]))->response()->setStatusCode(200);
        }catch(\Throwable $th){
            return (DefaultResource::make([
                'code' => 500,
                'message' => $th->getMessage(),
            ]))->response()->setStatusCode(500);
        }
    }

    public function dataUser(Request $request)
    {
        $data = $this->userInterface->customQuery($request);

        return BaseDatatable::Table($data);
    }

    public function listUser(Request $request)
    {
        if(!$request->role) $request->merge(['role' => 'teacher']); 

        $data = $this->userInterface->customQuery($request)->get();

        return DefaultResource::make($data)->response()->setStatusCode(200);
    }
}
