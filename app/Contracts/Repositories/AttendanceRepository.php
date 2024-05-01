<?php

namespace App\Contracts\Repositories;

use App\Contracts\Interfaces\AttendanceInterface;
use App\Models\Attendance;

class AttendanceRepository extends BaseRepository implements AttendanceInterface
{
    public function __construct(Attendance $model)
    {
        $this->model = $model;
    }

    /**
     * Delete attendance by student
     * @param mixed $studentId
     * @param mixed $classroomId
     * 
     * @return mixed
     */
    public function deleteAttendanceByStudent(mixed $studentId, mixed $classroomId): mixed
    {
        return $this->model->where('profile_id', $studentId)
            ->whereRelation('journal', 'classroom_id', $classroomId)
            ->delete();
    }
}
