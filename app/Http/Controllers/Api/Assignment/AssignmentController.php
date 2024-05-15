<?php

namespace App\Http\Controllers\Api\Assignment;

use App\Contracts\Interfaces\Assignment\MarkAssignmentInterface;
use App\Contracts\Interfaces\AssignmentInterface;
use App\Contracts\Interfaces\StudentInterface;
use App\Exports\MarkExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Assignment\StoreRequest;
use App\Http\Requests\Assignment\UpdateRequest;
use App\Http\Resources\AssignmentResource;
use App\Http\Resources\DefaultResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Excel as ExcelExcel;

class AssignmentController extends Controller
{
    private AssignmentInterface $assignment;
    private MarkAssignmentInterface $markAssignment;
    private StudentInterface $student;

    public function __construct(AssignmentInterface $assignment, MarkAssignmentInterface $markAssignment, StudentInterface $student)
    {
        $this->assignment = $assignment;
        $this->markAssignment = $markAssignment;
        $this->student = $student;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(String $lessonId)
    {
        $assignments = $this->assignment->get($lessonId);

        return AssignmentResource::make($assignments)->response()->setStatusCode(200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $data = $request->validated();

        $assignment = $this->assignment->store($data);
        $students = $this->student->getStudentByClassroom($assignment->lesson->classroom_id);
        foreach ($students as $student) {
            $data['classroom_student_id'] = $student->id;
            $data['assignment_id'] = $assignment->id;
            $this->markAssignment->store($data);
        }


        return DefaultResource::make(['code' => 201, 'message' => 'Berhasil menambahkan tugas'])->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $assignment = $this->assignment->show($id);

        return AssignmentResource::make($assignment)->response()->setStatusCode(200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id)
    {
        $data = $request->validated();

        $this->assignment->update($id, $data);

        return DefaultResource::make(['code' => 200, 'message' => 'Berhasil memperbarui tugas'])->response()->setStatusCode(200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $delete = $this->assignment->delete($id);

        if ($delete) {
            return DefaultResource::make(['code' => 200, 'message' => 'Berhasil menghapus tugas'])->response()->setStatusCode(200);
        }

        return DefaultResource::make(['code' => 500, 'message' => 'Gagal menghapus tugas'])->response()->setStatusCode(500);
    }

    /**
     * Export marks
     */
    public function exportMarks(string $assignmentId): JsonResponse
    {
        $marks = $this->assignment->exportMarks($assignmentId);

        $path = 'marks/' . date('His') . '-nilai' . '.xlsx';
        $url =  Excel::store(new MarkExport($marks), $path, null, ExcelExcel::XLSX);

        return DefaultResource::make(['code' => 200, 'message' => 'Berhasil mengekspor nilai', 'path' => $path])->response()->setStatusCode(200);
    }

    /**
     * Delete export marks
     */
    public function deleteExportMarks(Request $request): JsonResponse
    {
        $delete = $this->assignment->deleteExportMarks($request->path);

        if ($delete) {
            return DefaultResource::make(['code' => 200, 'message' => 'Berhasil menghapus file'])->response()->setStatusCode(200);
        }

        return DefaultResource::make(['code' => 500, 'message' => 'Gagal menghapus file'])->response()->setStatusCode(500);
    }
}
