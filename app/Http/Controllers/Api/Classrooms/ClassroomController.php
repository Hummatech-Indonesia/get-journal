<?php

namespace App\Http\Controllers\Api\Classrooms;

use App\Contracts\Interfaces\ClassroomInterface;
use App\Contracts\Interfaces\User\ProfileInterface;
use App\Contracts\Interfaces\User\UserInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Classroom\ChangeBackgroundRequest;
use App\Http\Requests\Classroom\StoreRequest;
use App\Http\Requests\Classroom\UpdateRequest;
use App\Http\Resources\ClassroomResource;
use App\Http\Resources\DefaultResource;
use App\Services\ClassroomService;
use Illuminate\Http\Request;

class ClassroomController extends Controller
{
    private ClassroomInterface $classroom;
    private ClassroomService $service;
    private UserInterface $user;
    private ProfileInterface $profile;

    public function __construct(ClassroomInterface $classroom, ClassroomService $service, UserInterface $user, ProfileInterface $profile)
    {
        $this->classroom = $classroom;
        $this->service = $service;
        $this->user = $user;
        $this->profile = $profile;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $classrooms = $this->classroom->getClassroomByUser(auth()->user()->profile->id);

        return (ClassroomResource::make($classrooms))->response()->setStatusCode(200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $data['code'] = $this->service->generateCode();

        $classrooms = $this->classroom->getClassroomByUser(auth()->user()->profile->id);

        if ($classrooms->count() >= 2 && auth()->user()->profile->is_premium == 0) {
            return DefaultResource::make(['code' => 400, 'errors' => ['Anda sudah mencapai batas maksimal kelas']])->response()->setStatusCode(400);
        }

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

    /**
     * Change background classroom
     */
    public function changeBackground(ChangeBackgroundRequest $request, mixed $id)
    {
        $data = $request->validated();
        $this->classroom->changeBackground($id, $data['background_id']);

        return DefaultResource::make(['code' => 200, 'message' => 'Berhasil mengubah background kelas'])->response()->setStatusCode(200);
    }

    /**
     * Display a listing of the resource.
     */
    public function classSchool(Request $request)
    {
        if(!$request->user_id) return (DefaultResource::make([
            'code' => 400,
            'message' => 'Field "user_id" harus di isi',
            'data' => null
        ]))->response()->setStatusCode(400);

        $user = $this->user->show($request->user_id);

        $userSchool = $this->profile->getWhereData(['related_code' => $user->profile->code]);
        $selectedIds = $userSchool->pluck('id')->toArray();
        
        $classrooms = $this->classroom->getClassSchoolPaginate($selectedIds,[
            "page" => $request->page ?? 1,
            "per_page" => 10
        ]);

        return (ClassroomResource::make([
            "success" => true,
            "message" => "Berhasil mengambil data kelas",
            "data" => $classrooms
        ]))->response()->setStatusCode(200);
    }
}
