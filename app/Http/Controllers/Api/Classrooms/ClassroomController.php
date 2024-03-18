<?php

namespace App\Http\Controllers\Api\Classrooms;

use App\Contracts\Interfaces\ClassroomInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Classroom\StoreRequest;
use App\Http\Requests\Classroom\UpdateRequest;
use App\Http\Resources\ClassroomResource;
use App\Http\Resources\DefaultResource;

class ClassroomController extends Controller
{
    private ClassroomInterface $classroom;

    public function __construct(ClassroomInterface $classroom)
    {
        $this->classroom = $classroom;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $classrooms = $this->classroom->get();

        return (ClassroomResource::make($classrooms))->response()->setStatusCode(200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $classroom = $this->classroom->store($data);

        return DefaultResource::make(['code' => 201, 'message' => 'Berhasil menambahkan kelas'])->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $classroom = $this->classroom->show($id);

        return (ClassroomResource::make($classroom))->response()->setStatusCode(200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id)
    {
        $data = $request->validated();
        $this->classroom->update($id, $data);

        return DefaultResource::make(['code' => 200, 'message' => 'Berhasil mengedit kelas'])->response()->setStatusCode(200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $delete = $this->classroom->delete($id);

        if (!$delete) {
            return DefaultResource::make(['code' => 500, 'message' => 'Gagal menghapus kelas'])->response()->setStatusCode(500);
        }

        return DefaultResource::make(['code' => 200, 'message' => 'Berhasil menghapus kelas'])->response()->setStatusCode(200);
    }
}
