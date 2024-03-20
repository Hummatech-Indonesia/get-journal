<?php

namespace App\Observers;

use App\Models\Reminder;
use Illuminate\Support\Str;

class ReminderObserver
{
    public function creating(Reminder $reminder): void
    {
        $reminder->id = Str::uuid();
        $reminder->profile_id = auth()->user()->profile->id;
    }

    /**
     * Handle the Reminder "created" event.
     */
    public function created(Reminder $reminder): void
    {
        //
    }

    /**
     * Handle the Reminder "updated" event.
     */
    public function updated(Reminder $reminder): void
    {
        //
    }

    /**
     * Handle the Reminder "deleted" event.
     */
    public function deleted(Reminder $reminder): void
    {
        //
    }

    /**
     * Handle the Reminder "restored" event.
     */
    public function restored(Reminder $reminder): void
    {
        //
    }

    /**
     * Handle the Reminder "force deleted" event.
     */
    public function forceDeleted(Reminder $reminder): void
    {
        //
    }
}
