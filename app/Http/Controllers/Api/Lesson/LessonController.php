<?php

namespace App\Http\Controllers\Api\Lesson;

use App\Contracts\Interfaces\LessonInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Lesson\StoreRequest;
use App\Http\Requests\Lesson\UpdateRequest;
use App\Http\Resources\DefaultResource;
use App\Http\Resources\LessonResource;
use Illuminate\Http\Request;

class LessonController extends Controller
{

    private LessonInterface $lesson;

    public function __construct(LessonInterface $lesson)
    {
        $this->lesson = $lesson;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(String $classroom_id)
    {
        return (LessonResource::make($this->lesson->get($classroom_id)))->response()->setStatusCode(200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $this->lesson->store($data);
        return DefaultResource::make(['code' => 201, 'message' => 'Data berhasil disimpan'])->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return LessonResource::make($this->lesson->show($id))->response()->setStatusCode(200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id)
    {
        $data = $request->validated();
        $this->lesson->update($id, $data);
        return DefaultResource::make(['code' => 200, 'message' => 'Data berhasil diubah'])->response()->setStatusCode(200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $delete = $this->lesson->delete($id);
        if ($delete) {
            return DefaultResource::make(['code' => 200, 'message' => 'Data berhasil dihapus'])->response()->setStatusCode(200);
        }
        return DefaultResource::make(['code' => 500, 'message' => 'Data gagal dihapus'])->response()->setStatusCode(500);
    }
}
