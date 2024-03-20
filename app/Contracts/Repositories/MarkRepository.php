<?php

namespace App\Contracts\Repositories;

use App\Contracts\Interfaces\Assignment\MarkAssignmentInterface;
use App\Models\Mark;

class MarkRepository extends BaseRepository implements MarkAssignmentInterface
{
    public function __construct(Mark $mark)
    {
        $this->model = $mark;
    }

    /**
     * Mark the assignment
     */
    public function mark(array $datas): void
    {
        foreach ($datas as $data) {
            $this->model->updateOrCreate(['assignment_id' => $data['assignment_id'], 'classroom_student_id' => $data['classroom_student_id']], $data);
        }
    }
}
