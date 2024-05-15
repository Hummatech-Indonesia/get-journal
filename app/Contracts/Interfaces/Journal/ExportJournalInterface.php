<?php

namespace App\Contracts\Interfaces\Journal;

interface ExportJournalInterface
{
    public function exportJournal(mixed $startSate, mixed $endDate, mixed $classroomId): mixed;
}
