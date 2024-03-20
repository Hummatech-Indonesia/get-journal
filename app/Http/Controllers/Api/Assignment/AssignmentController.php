<?php

namespace App\Http\Controllers\Api\Assignment;

use App\Contracts\Interfaces\AssignmentInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Assignment\StoreRequest;
use App\Http\Requests\Assignment\UpdateRequest;
use App\Http\Resources\AssignmentResource;
use App\Http\Resources\DefaultResource;

class AssignmentController extends Controller
{
    private AssignmentInterface $assignment;

    public function __construct(AssignmentInterface $assignment)
    {
        $this->assignment = $assignment;
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

        $this->assignment->store($data);

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
}
