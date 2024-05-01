<?php

namespace App\Http\Controllers\Api\Student;

use App\Contracts\Interfaces\AttendanceInterface;
use App\Contracts\Interfaces\StudentInterface;
use App\Contracts\Interfaces\User\ProfileInterface;
use App\Contracts\Interfaces\User\UserInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Student\StoreRequest;
use App\Http\Resources\DefaultResource;
use App\Http\Resources\StudentResource;
use App\Models\ClassroomStudent;

class StudentController extends Controller
{
    private StudentInterface $student;
    private UserInterface $user;
    private ProfileInterface $profile;
    private AttendanceInterface $attendance;

    public function __construct(StudentInterface $student, UserInterface $user, ProfileInterface $profile, AttendanceInterface $attendance)
    {
        $this->student = $student;
        $this->user = $user;
        $this->profile = $profile;
        $this->attendance = $attendance;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(mixed $id)
    {
        $students = $this->student->getStudentByClassroom($id);

        return StudentResource::make($students)->response()->setStatusCode(200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $data = $request->validated();

        if ($this->profile->checkAvailableStudent($data['identity_number'])) {
            $profile = $this->profile->getProfileByIdentityNumber($data['identity_number']);

            $this->student->store([
                'student_id' => $profile->id,
                'classroom_id' => $data['classroom_id'],
            ]);
        } else {
            $user = $this->user->store([
                'email' => $data['email'],
                'password' => bcrypt('password'),
            ]);
            $user->assignRole('student');
            $data['user_id'] = $user->id->serialize();

            $profile = $this->profile->store($data);

            $this->student->store([
                'student_id' => $profile->id->serialize(),
                'classroom_id' => $data['classroom_id'],
            ]);
        }

        return DefaultResource::make(['code' => 201, 'message' => 'Berhasil menambahkan siswa'])->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ClassroomStudent $student)
    {
        dd($student);
        $delete = $this->student->delete($student->id);

        if ($delete) {
            $this->attendance->deleteAttendanceByStudent($classroomStudent->student_id, $classroomStudent->classroom_id);
            return DefaultResource::make(['code' => 200, 'message' => 'Berhasil menghapus siswa'])->response()->setStatusCode(200);
        }

        return DefaultResource::make(['code' => 500, 'message' => 'Gagal menghapus siswa'])->response()->setStatusCode(500);
    }
}
