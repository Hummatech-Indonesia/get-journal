<?php

namespace App\Providers;

use App\Contracts\Interfaces\AuthInterface;
use App\Contracts\Interfaces\ClassroomInterface;
use App\Contracts\Repositories\AuthRepository;
use App\Contracts\Repositories\ClassroomRepository;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    private array $register = [
        AuthInterface::class => AuthRepository::class,
        ClassroomInterface::class => ClassroomRepository::class,
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
