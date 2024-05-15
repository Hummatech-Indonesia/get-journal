<?php

namespace App\Exports;

use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class AttendanceExport implements FromView
{
    private $classroomStudents;
    private $journals;

    public function __construct($classroomStudents, $journals)
    {
        $this->classroomStudents = $classroomStudents;
        $this->journals = $journals;
    }

    public function view(): View
    {
        return view('exports.attendance', [
            'classroomStudents' => $this->classroomStudents,
            'journals' => $this->journals,
        ]);
    }
}
