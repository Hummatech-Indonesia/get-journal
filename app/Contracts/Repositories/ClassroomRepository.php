<?php

namespace App\Contracts\Repositories;

use App\Contracts\Interfaces\ClassroomInterface;
use App\Models\Classroom;
use App\Models\ClassroomStudent;
use Illuminate\Http\Request;

class ClassroomRepository extends BaseRepository implements ClassroomInterface
{
    private ClassroomStudent $classroomStudent;

    public function __construct(Classroom $model)
    {
        $this->model = $model;
    }

    /**
     * Get all classrooms
     */
    public function getClassroomByUser(mixed $profileId): mixed
    {
        return $this->model->with('background')->withCount('students')->where('profile_id', $profileId)->get();
    }

    /**
     * Get all the assignments by classroom id
     */
    public function getAssignmentByClassroom(mixed $id): mixed
    {
        return $this->model->with('assignments')->where('id', $id)->first();
    }

    /**
     * Get a specific classroom
     */
    public function show(mixed $id): mixed
    {
        return $this->model->withCount('students')->where('id', $id)->first();
    }

    /**
     * Store a new classroom
     */
    public function store(array $data): mixed
    {
        return $this->model->create($data);
    }

    /**
     * Update a specific classroom
     */
    public function update(mixed $id, array $data): mixed
    {
        return $this->model->find($id)->update($data);
    }

    /**
     * Delete a specific classroom
     */
    public function delete(mixed $id): mixed
    {
        try {
            $this->model->find($id)->delete();

            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    /**
     * Generate code
     */
    public function generateCode(String $code, mixed $id): mixed
    {
        return $this->model->find($id)->update(['code' => $code]);
    }

    /**
     * Change Background Classroom
     */
    public function changeBackground(mixed $id, mixed $background): mixed
    {
        return $this->model->find($id)->update(['background_id' => $background]);
    }

    public function getClassSchool(array $ids): mixed
    {
        return $this->model->query()
        ->with('profile','assignments')
        ->withCount('students','assignments')
        ->whereIn('profile_id',$ids)
        ->get();
    }
    
    public function getClassSchoolPaginate(array $ids, ?array $payload): mixed
    {
        $page = 1;
        $per_page = 10;
        try{
            $page = $payload["page"];
            $per_page = $payload["per_page"]; 
        }catch(\Throwable $th){ }

        return $this->model->query()
        ->with('profile','assignments','background')
        ->withCount('students','assignments')
        ->whereIn('profile_id',$ids)
        ->paginate($per_page, ['*'], 'page', $page);
    }

    public function getStudentByClass(Request $request): mixed
    {
        return $this->model->query()
        ->with(['profile','students'])
        ->when($request->classroom_id, function ($query) use ($request){
            $query->where('id', $request->classroom_id);
        })
        ->when($request->code, function ($query) use ($request){
            $query->whereRelation('profile','related_code', $request->code);
        })
        ->get();
    }

    public function detailClass(mixed $id): mixed
    {
        return $this->model->query()
        ->with('profile')
        ->withCount('assignments')
        ->find($id);
    }
}
