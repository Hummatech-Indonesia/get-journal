<?php

namespace App\Contracts\Interfaces\Assignment;

interface ExportMarkInterface
{
    public function exportMarks(mixed $assignmentId): mixed;

    public function deleteExportMarks(string $path): mixed;
}
