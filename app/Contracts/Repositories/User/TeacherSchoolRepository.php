<?php

namespace App\Contracts\Repositories\User;

use App\Contracts\Interfaces\User\AssignTeacherToSchoolInterface;
use App\Contracts\Repositories\BaseRepository;
use App\Models\TeacherSchool;
use App\Models\User;
use Faker\Provider\Base;

class TeacherSchoolRepository extends BaseRepository implements AssignTeacherToSchoolInterface
{
    public function __construct(TeacherSchool $teacherSchool)
    {
        $this->model = $teacherSchool;
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

    /**
     * Delete user
     *
     * @param mixed $id
     * @return mixed
     */
    public function delete(mixed $id): mixed
    {
        return $this->model->find($id)->delete();
    }

    /**
     * gwt where data user
     *
     * @param mixed $id
     * @return mixed
     */
    public function getWhere(array $data): mixed
    {
        return $this->model->query()
        ->when(count($data) > 0, function ($query) use ($data){
            $type = null;
            try { $type = $data["type"]; unset($data["type"]); } catch(\Throwable $th) {  }

            foreach($data as $item => $value){
                $query->where($item, $value);
            }

            // if($type == "get") $query->get();
            // else $query->first();
        })
        ->first();
    }
}
