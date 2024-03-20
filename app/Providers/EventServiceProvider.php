<?php

namespace App\Providers;

use App\Models\Assignment;
use App\Models\Classroom;
use App\Models\Lesson;
use App\Models\Profile;
use App\Models\Reminder;
use App\Models\User;
use App\Observers\AssignmentObserver;
use App\Observers\ClassroomObserver;
use App\Observers\LessonObserver;
use App\Observers\ProfileObserver;
use App\Observers\ReminderObserver;
use App\Observers\UserObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        User::observe(UserObserver::class);
        Profile::observe(ProfileObserver::class);
        Classroom::observe(ClassroomObserver::class);
        Lesson::observe(LessonObserver::class);
        Assignment::observe(AssignmentObserver::class);
        Reminder::observe(ReminderObserver::class);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
