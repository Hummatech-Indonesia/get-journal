<?php

namespace App\Observers;

use App\Models\Classroom;
use Illuminate\Support\Str;

class ClassroomObserver
{
    /**
     * Handle the Classroom "creating" event.
     */
    public function creating(Classroom $classroom): void
    {
        $classroom->id = Str::uuid();
        $classroom->profile_id = auth()->user()->profile->id;
    }

    /**
     * Handle the Classroom "created" event.
     */
    public function created(Classroom $classroom): void
    {
        //
    }

    /**
     * Handle the Classroom "updated" event.
     */
    public function updated(Classroom $classroom): void
    {
        //
    }

    /**
     * Handle the Classroom "deleted" event.
     */
    public function deleted(Classroom $classroom): void
    {
        //
    }

    /**
     * Handle the Classroom "restored" event.
     */
    public function restored(Classroom $classroom): void
    {
        //
    }

    /**
     * Handle the Classroom "force deleted" event.
     */
    public function forceDeleted(Classroom $classroom): void
    {
        //
    }
}
