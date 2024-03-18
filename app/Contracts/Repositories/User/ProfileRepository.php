<?php

namespace App\Contracts\Repositories\User;

use App\Contracts\Interfaces\User\ProfileInterface;
use App\Contracts\Interfaces\User\UserInterface;
use App\Contracts\Repositories\BaseRepository;
use App\Models\Profile;

class ProfileRepository extends BaseRepository implements ProfileInterface
{
    public function __construct(Profile $user)
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
     * check available student by identity number
     * 
     * @param mixed $identityNumber
     * @return mixed
     */
    public function checkAvailableStudent(mixed $identityNumber): mixed
    {
        $student = $this->model->where('identity_number', $identityNumber)->count();

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
    public function getProfileByIdentityNumber(mixed $identityNumber): mixed
    {
        return $this->model->where('identity_number', $identityNumber)->first();
    }
}
