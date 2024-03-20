<?php

namespace App\Observers;

use App\Models\Journal;
use Illuminate\Support\Str;

class JournalObserver
{
    public function creating(Journal $journal): void
    {
        $journal->id = Str::uuid();
        $journal->profile_id = auth()->user()->profile->id;
    }

    /**
     * Handle the Journal "created" event.
     */
    public function created(Journal $journal): void
    {
        //
    }

    /**
     * Handle the Journal "updated" event.
     */
    public function updated(Journal $journal): void
    {
        //
    }

    /**
     * Handle the Journal "deleted" event.
     */
    public function deleted(Journal $journal): void
    {
        //
    }

    /**
     * Handle the Journal "restored" event.
     */
    public function restored(Journal $journal): void
    {
        //
    }

    /**
     * Handle the Journal "force deleted" event.
     */
    public function forceDeleted(Journal $journal): void
    {
        //
    }
}
