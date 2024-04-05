<?php

namespace App\Contracts\Repositories;

use App\Contracts\Interfaces\ReminderInterface;
use App\Models\Reminder;
use Illuminate\Support\Facades\DB;

class ReminderRepository extends BaseRepository implements ReminderInterface
{
    public function __construct(Reminder $model)
    {
        $this->model = $model;
    }

    /**
     * Get all reminders by user
     *
     * @param mixed $userId
     * @return mixed
     */
    public function getReminderByUser(mixed $userId): mixed
    {
        // return $this->model->where('profile_id', $userId)->get();
        return $this->model
            ->select(DB::raw('MONTH(reminder_at) as bulan'), DB::raw('id, profile_id, title, content, reminder_at, created_at, updated_at'))
            ->groupBy(DB::raw('MONTH(reminder_at)'))
            ->where('profile_id', $userId)
            ->get();
    }

    /**
     * Display the specified resource.
     *
     * @param mixed $id
     * @return mixed
     */
    public function show(mixed $id): mixed
    {
        return $this->model->find($id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param array $data
     * @return mixed
     */
    public function store(array $data): mixed
    {
        return $this->model->create($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param mixed $id
     * @param array $data
     * @return mixed
     */
    public function update(mixed $id, array $data): mixed
    {
        return $this->model->where('id', $id)->update($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param mixed $id
     * @return mixed
     */
    public function delete(mixed $id): mixed
    {
        try {
            $this->model->where('id', $id)->delete();
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
}
