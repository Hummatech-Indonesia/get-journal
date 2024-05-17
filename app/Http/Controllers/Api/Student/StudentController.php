<?php

namespace App\Http\Controllers\Api\Student;

use App\Contracts\Interfaces\AttendanceInterface;
use App\Contracts\Interfaces\ClassroomInterface;
use App\Contracts\Interfaces\JournalInterface;
use App\Contracts\Interfaces\StudentInterface;
use App\Contracts\Interfaces\User\ProfileInterface;
use App\Contracts\Interfaces\User\UserInterface;
use App\Exports\AttendanceExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Student\StoreRequest;
use App\Http\Resources\DefaultResource;
use App\Http\Resources\StudentResource;
use App\Models\ClassroomStudent;
use App\Services\StudentService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Excel as ExcelExcel;

class StudentController extends Controller
{
    private StudentInterface $student;
    private UserInterface $user;
    private ProfileInterface $profile;
    private AttendanceInterface $attendance;
    private JournalInterface $journal;
    private ClassroomInterface $classroom;
    private StudentService $studentService;

    public function __construct(StudentInterface $student, UserInterface $user, ProfileInterface $profile, AttendanceInterface $attendance, JournalInterface $journal, ClassroomInterface $classroom, StudentService $studentService)
    {
        $this->student = $student;
        $this->user = $user;
        $this->profile = $profile;
        $this->attendance = $attendance;
        $this->journal = $journal;
        $this->classroom = $classroom;
        $this->studentService = $studentService;
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
        $classroomStudent = 0;

        if ($this->profile->checkAvailableStudent($data['email'])) {
            $profile = $this->profile->getProfileByEmail($data['email']);

            $classroomStudent = $this->student->store([
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

            $classroomStudent = $this->student->store([
                'student_id' => $profile->id->serialize(),
                'classroom_id' => $data['classroom_id'],
            ]);
        }

        $assignments = $this->classroom->getAssignmentByClassroom($data['classroom_id']);
        $this->studentService->createMarkNewStudent($classroomStudent->id, $assignments->assignments);

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
        $delete = $this->student->delete($student->id);

        if ($delete) {
            $this->attendance->deleteAttendanceByStudent($student->student_id, $student->classroom_id);
            return DefaultResource::make(['code' => 200, 'message' => 'Berhasil menghapus siswa'])->response()->setStatusCode(200);
        }

        return DefaultResource::make(['code' => 500, 'message' => 'Gagal menghapus siswa'])->response()->setStatusCode(500);
    }

    /**
     * Export attendance
     */
    public function exportAttendance(mixed $classroom_id)
    {
        $students = $this->student->exportAttendance($classroom_id);
        $journals = $this->journal->getJournalByClassroom($classroom_id);

        $path = 'attendances/' . date('His') . '-absensi' . '.xlsx';
        $url =  Excel::store(new AttendanceExport($students, $journals), $path, null, ExcelExcel::XLSX);

        return DefaultResource::make(['code' => 200, 'message' => 'Berhasil mengekspor absensi', 'url' => $path])->response()->setStatusCode(200);
    }

    /**
     * Delete exported attendance
     */
    public function deleteExportedAttendance(Request $request)
    {
        $delete = $this->student->deleteExportedAttendance($request->path);

        if ($delete) {
            return DefaultResource::make(['code' => 200, 'message' => 'Berhasil menghapus data'])->response()->setStatusCode(200);
        }

        return DefaultResource::make(['code' => 500, 'message' => 'Gagal menghapus data'])->response()->setStatusCode(500);
    }
}
