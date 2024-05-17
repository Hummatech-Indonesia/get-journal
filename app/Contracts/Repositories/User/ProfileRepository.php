<?php

namespace App\Contracts\Repositories\User;

use App\Contracts\Interfaces\User\ProfileInterface;
use App\Contracts\Repositories\BaseRepository;
use App\Models\Profile;

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
}
