<?php

namespace App\Contracts\Interfaces;

use App\Contracts\Interfaces\Eloquent\DeleteInterface;
use App\Contracts\Interfaces\Eloquent\GetWhereInterface;
use App\Contracts\Interfaces\Eloquent\ShowInterface;
use App\Contracts\Interfaces\Eloquent\StoreInterface;
use App\Contracts\Interfaces\Eloquent\UpdateInterface;
use App\Contracts\Interfaces\Journal\DeleteAttendanceByStudentInterface;
use App\Contracts\Interfaces\Journal\ExportJournalInterface;
use App\Contracts\Interfaces\Journal\GetJournalByClassroomInterface;
use App\Contracts\Interfaces\Journal\GetJournalByUserInterface;

interface JournalInterface extends GetJournalByUserInterface, GetJournalByClassroomInterface, StoreInterface, UpdateInterface, DeleteInterface, ShowInterface, ExportJournalInterface, GetWhereInterface
{
}
