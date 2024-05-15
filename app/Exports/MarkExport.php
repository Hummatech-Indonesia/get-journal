<?php

namespace App\Exports;

use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class MarkExport implements FromView
{
    private $data;

    public function __construct(mixed $data)
    {
        $this->data = $data;
    }

    /**
     * @return View
     */
    public function view(): View
    {
        return view('exports.marks', [
            'assignment' => $this->data
        ]);
    }
}
