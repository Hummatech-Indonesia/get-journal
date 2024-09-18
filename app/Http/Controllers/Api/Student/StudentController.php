<?php

namespace App\Http\Controllers\Api\Student;

use App\Contracts\Interfaces\Assignment\MarkAssignmentInterface;
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
use App\Models\Mark;
use App\Services\StudentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
    private MarkAssignmentInterface $markAssignment;

    public function __construct(StudentInterface $student, UserInterface $user, ProfileInterface $profile, AttendanceInterface $attendance, JournalInterface $journal, ClassroomInterface $classroom, StudentService $studentService, MarkAssignmentInterface $markAssignment)
    {
        $this->student = $student;
        $this->user = $user;
        $this->profile = $profile;
        $this->attendance = $attendance;
        $this->journal = $journal;
        $this->classroom = $classroom;
        $this->studentService = $studentService;
        $this->markAssignment = $markAssignment;
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

        $check_email = $this->user->getWhere(["email" => $data["email"]]);
        DB::beginTransaction();
        try{
            if ($check_email) {
                $profile = $check_email->profile;
                
                if(!$profile) {
                    $data['user_id'] = $check_email->id;
                    unset($data['email']);
                    $classroom_id = $data["classroom_id"];
                    unset($data["classroom_id"]);
        
                    $profile = $this->profile->store($data);
                    $data["classroom_id"] = $classroom_id;
                }

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
                unset($data['email']);
                $classroom_id = $data["classroom_id"];
                unset($data["classroom_id"]);
    
                $profile = $this->profile->store($data);
                $data["classroom_id"] = $classroom_id;

                $classroomStudent = $this->student->store([
                    'student_id' => $profile->id->serialize(),
                    'classroom_id' => $data['classroom_id'],
                ]);
            }
    
            $assignments = $this->classroom->getAssignmentByClassroom($data['classroom_id']);
            $this->studentService->createMarkNewStudent($classroomStudent->id, $assignments->assignments);
    
            DB::commit();
            return DefaultResource::make(['code' => 201, 'message' => 'Berhasil menambahkan siswa'])->response()->setStatusCode(201);
        }catch(\Throwable $th){
            DB::rollBack();
            return DefaultResource::make(['code' => 500, 'message' => $th->getMessage()])->response()->setStatusCode(500);
        }
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
            $this->markAssignment->deleteMarkByStudent($student->id);

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
