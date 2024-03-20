<?php

namespace App\Providers;

use App\Contracts\Interfaces\Assignment\MarkAssignmentInterface;
use App\Contracts\Interfaces\AssignmentInterface;
use App\Contracts\Interfaces\AuthInterface;
use App\Contracts\Interfaces\ClassroomInterface;
use App\Contracts\Interfaces\LessonInterface;
use App\Contracts\Interfaces\StudentInterface;
use App\Contracts\Interfaces\User\ProfileInterface;
use App\Contracts\Interfaces\User\UserInterface;
use App\Contracts\Repositories\AssignmentRepository;
use App\Contracts\Repositories\AuthRepository;
use App\Contracts\Repositories\ClassroomRepository;
use App\Contracts\Repositories\LessonRepository;
use App\Contracts\Repositories\MarkRepository;
use App\Contracts\Repositories\StudentRepository;
use App\Contracts\Repositories\User\ProfileRepository;
use App\Contracts\Repositories\User\UserRepository;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    private array $register = [
        AuthInterface::class => AuthRepository::class,
        ClassroomInterface::class => ClassroomRepository::class,
        LessonInterface::class => LessonRepository::class,
        UserInterface::class => UserRepository::class,
        ProfileInterface::class => ProfileRepository::class,
        StudentInterface::class => StudentRepository::class,
        AssignmentInterface::class => AssignmentRepository::class,
        MarkAssignmentInterface::class => MarkRepository::class,
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        foreach ($this->register as $index => $value) $this->app->bind($index, $value);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        JsonResource::withoutWrapping();
    }
}
