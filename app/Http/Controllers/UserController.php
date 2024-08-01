<?php

namespace App\Http\Controllers;

use App\Contracts\Interfaces\User\AssignTeacherToSchoolInterface;
use App\Contracts\Interfaces\User\UserInterface;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\User\AssignTeacherRequest;
use App\Http\Resources\DefaultResource;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private UserInterface $user;
    private AssignTeacherToSchoolInterface $assignTeacher;

    public function __construct(UserInterface $user, AssignTeacherToSchoolInterface $assignTeacher)
    {
        $this->user = $user;
        $this->assignTeacher = $assignTeacher;
    }

    /**
     * Show the form for deleting the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteAccount()
    {
        return view('pages.users.delete-account');
    }

    /**
     * Process the delete account request.
     *
     * @param LoginRequest $request
     * @return \Illuminate\Http\Response
     */
    public function processDeleteAccount(LoginRequest $request)
    {
        $credentials = $request->validated();

        if (auth()->attempt($credentials)) {
            $this->user->delete(auth()->user()->id);
        }

        return redirect()->back();
    }
}
