<?php

namespace App\Contracts\Interfaces\Journal;

interface GetJournalByClassroomInterface
{
    public function getJournalByClassroom(mixed $classroom_id): mixed;
}
