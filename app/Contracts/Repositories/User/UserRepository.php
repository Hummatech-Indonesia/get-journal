<?php

namespace App\Contracts\Repositories\User;

use App\Contracts\Interfaces\User\UserInterface;
use App\Contracts\Repositories\BaseRepository;
use App\Models\User;
use Faker\Provider\Base;

class UserRepository extends BaseRepository implements UserInterface
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
    public function updatePassword(mixed $id, array $data): mixed
    {
        // dd($this->model->find($id)->update($data));
        return $this->model->find($id)->update(['password' => bcrypt($data['new_password'])]);
    }
}
