<?php

namespace App\Http\Controllers\Api\Classrooms;

use App\Contracts\Interfaces\ClassroomInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Classroom\StoreRequest;
use App\Http\Requests\Classroom\UpdateRequest;
use App\Http\Resources\ClassroomResource;
use App\Http\Resources\DefaultResource;
use App\Services\ClassroomService;

class ClassroomController extends Controller
{
    private ClassroomInterface $classroom;
    private ClassroomService $service;

    public function __construct(ClassroomInterface $classroom, ClassroomService $service)
    {
        $this->classroom = $classroom;
        $this->service = $service;
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
        $data['code'] = $this->service->generateCode();
        $classroom = $this->classroom->store($data);

        return DefaultResource::make(['code' => 201, 'message' => 'Berhasil menambahkan kelas'])->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $classroom = $this->classroom->show($id);
        dd($classroom);
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

    /**
     * Generate code for classroom
     */
    public function generateCode(mixed $id)
    {
        $code = $this->service->generateCode();
        $this->classroom->generateCode($code, $id);
        $classroom = $this->classroom->show($id);

        return ClassroomResource::make($classroom)->response()->setStatusCode(200);
    }
}
