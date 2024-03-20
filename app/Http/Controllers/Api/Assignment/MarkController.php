<?php

namespace App\Http\Controllers\Api\Assignment;

use App\Contracts\Interfaces\Assignment\MarkAssignmentInterface;
use App\Contracts\Repositories\StudentRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\Assignment\MarkRequest;
use App\Http\Resources\DefaultResource;
use App\Http\Resources\MarkResource;
use App\Models\Mark;
use Illuminate\Http\Request;

class MarkController extends Controller
{
    private StudentRepository $student;
    private MarkAssignmentInterface $mark;

    public function __construct(StudentRepository $student, MarkAssignmentInterface $mark)
    {
        $this->student = $student;
        $this->mark = $mark;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(String $assignmentId)
    {
        $student_marks = $this->student->getClassroomStudentByAssignment($assignmentId);
        return MarkResource::make($student_marks)->response()->setStatusCode(200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MarkRequest $request)
    {
        $data = $request->validated();
        $this->mark->mark($data['marks']);

        return DefaultResource::make(['code' => 201, 'message' => 'Berhasil menilai siswa'])->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
