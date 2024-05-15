<?php

namespace App\Contracts\Interfaces\Classrooms;

interface ExportAttendanceInterface
{
    public function exportAttendance(mixed $classroom_id): mixed;
    public function deleteExportedAttendance(string $path): mixed;
}
