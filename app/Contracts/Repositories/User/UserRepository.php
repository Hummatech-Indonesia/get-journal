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
}
