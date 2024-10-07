<?php

namespace App\Http\Controllers\Api\Assignment;

use App\Contracts\Interfaces\Assignment\MarkAssignmentInterface;
use App\Contracts\Interfaces\StudentInterface;
use App\Contracts\Repositories\StudentRepository;
use App\Helpers\BaseDatatable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Assignment\MarkRequest;
use App\Http\Resources\DefaultResource;
use App\Http\Resources\MarkResource;
use App\Models\Mark;
use Illuminate\Http\Request;

class MarkController extends Controller
{
    private MarkAssignmentInterface $mark;

    public function __construct(MarkAssignmentInterface $mark)
    {
        $this->mark = $mark;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(String $assignmentId)
    {
        $student_marks = $this->mark->getClassroomStudentByAssignment($assignmentId);
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

    public function tableMarks(Request $request)
    {
        $payload = [];

        if($request->student_id) $payload["student_id"] = $request->student_id;

        $data = $this->mark->customQuery($payload);

        return BaseDatatable::Table($data);
    }
}
