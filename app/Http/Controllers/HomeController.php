<?php

namespace App\Http\Controllers;

use App\Contracts\Interfaces\ClassroomInterface;
use App\Contracts\Interfaces\User\ProfileInterface;
use App\Contracts\Interfaces\User\UserInterface;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    private UserInterface $user;
    private ProfileInterface $profile;
    private ClassroomInterface $classroom;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserInterface $user, ProfileInterface $profile, ClassroomInterface $classroom)
    {
        $this->middleware('auth');
        $this->user = $user;
        $this->profile = $profile;
        $this->classroom = $classroom;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $profile = auth()->user()->profile;

        $request->merge(['role' => 'teacher', 'code' => $profile->code]); 
        $count_teacher = $this->user->customQuery($request)->count();

        $request->merge(['role' => 'student', 'code' => $profile->code]); 
        $count_student = $this->profile->getDataStudent($request)->count();

        $userSchool = $this->profile->getWhereData(['related_code' => $profile->code]);
        $selectedIds = $userSchool->pluck('id')->toArray();
        $count_classroom = $this->classroom->getClassSchool($selectedIds)->count();

        $data = (object)[
            "premium" => $profile->quantity_premium,
            "teacher" => $count_teacher,
            "student" => $count_student,
            "classroom" => $count_classroom
        ];
        return view('pages.users.dashboard.index', compact('data'));
    }
}
