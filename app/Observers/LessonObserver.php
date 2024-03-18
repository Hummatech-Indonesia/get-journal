<?php

namespace App\Observers;

use App\Models\Lesson;
use Illuminate\Support\Str;

class LessonObserver
{

    public function creating(Lesson $lesson): void
    {
        $lesson->id = Str::uuid();
    }

    /**
     * Handle the Lesson "created" event.
     */
    public function created(Lesson $lesson): void
    {
        //
    }

    /**
     * Handle the Lesson "updated" event.
     */
    public function updated(Lesson $lesson): void
    {
        //
    }

    /**
     * Handle the Lesson "deleted" event.
     */
    public function deleted(Lesson $lesson): void
    {
        //
    }

    /**
     * Handle the Lesson "restored" event.
     */
    public function restored(Lesson $lesson): void
    {
        //
    }

    /**
     * Handle the Lesson "force deleted" event.
     */
    public function forceDeleted(Lesson $lesson): void
    {
        //
    }
}
