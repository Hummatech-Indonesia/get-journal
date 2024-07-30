<?php

namespace App\Contracts\Repositories\User;

use App\Contracts\Interfaces\User\AssignTeacherToSchoolInterface;
use App\Contracts\Repositories\BaseRepository;
use App\Models\User;
use Faker\Provider\Base;

class TeacherSchoolRepository extends BaseRepository implements AssignTeacherToSchoolInterface
{
    public function __construct(User $user)
    {
        $this->model = $user;
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
}
