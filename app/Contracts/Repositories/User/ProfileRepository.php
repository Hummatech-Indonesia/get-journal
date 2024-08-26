<?php

namespace App\Contracts\Repositories\User;

use App\Contracts\Interfaces\User\ProfileInterface;
use App\Contracts\Repositories\BaseRepository;
use App\Models\Profile;
use Illuminate\Http\Request;

class ProfileRepository extends BaseRepository implements ProfileInterface
{
    public function __construct(Profile $user)
    {
        $this->model = $user;
    }

    /**
     * Get user info
     *
     * @param mixed $profileId
     * @return mixed
     */
    public function getUserInfo(mixed $profileId): mixed
    {
        return $this->model
            ->with('user', 'getSchoolRelated')
            ->withCount('classrooms', 'lessons', 'reminders', 'journals')
            ->where('id', $profileId)->first();
    }

    /**
     * Store a new user
     *
     * @param array $data
     * @return mixed
     */
    public function store(array $data): mixed
    {
        return $this->model->create($data);
    }

    /**
     * check available student by email
     * 
     * @param mixed $data
     * @return mixed
     */
    public function checkAvailableStudent(mixed $data): mixed
    {
        $student = $this->model
            ->whereRelation('user', 'email', $data)
            ->count();

        if ($student > 0) {
            return true;
        }

        return false;
    }

    /**
     * Display the specified resource.
     *
     * @param mixed $id
     * @return mixed
     */
    public function getProfileByEmail(mixed $email): mixed
    {
        return $this->model->whereRelation('user', 'email', $email)->first();
    }
    /**
     * Update user
     *
     * @param mixed $id
     * @param array $data
     * @return mixed
     */
    public function update(mixed $id, array $data): mixed
    {
        return $this->model->find($id)->update($data);
    }

    public function getWhereData(array $data): mixed
    {
        return $this->model->query()
        ->when(count($data) > 0, function ($query) use ($data){
            foreach($data as $index => $value){
                $query->where($index, $value);
            }
        })        
        ->get();
    } 

    public function getDataStudent(Request $request): mixed
    {
        return $this->model->query()
        ->with(['oneStudent.classroom.profile', 'user'])
        ->whereHas('oneStudent')
        ->when($request->classroom_id, function ($query) use ($request){
            $query->whereRelation('oneStudent', 'classroom_id', $request->classroom_id);
        })
        ->when($request->code, function ($query) use ($request){
            $query->whereRelation('oneStudent.classroom.profile', 'related_code', $request->code);
        });
    }

    
    public function detailStudent(mixed $id): mixed
    {
        return $this->model->query()
        ->with(['attendances', 'student' => function ($query) {
            $query->with(['classroom' => function ($query2){
                $query2->withCount('assignments');
            }]);
        }])
        ->withCount('permit','sick','alpha')
        ->find($id);
    }
}
