<?php

namespace App\Providers;

use App\Repositories\Interfaces\NoteRepositoryInterface;
use App\Repositories\NoteRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(NoteRepositoryInterface::class, NoteRepository::class);
    }
}
