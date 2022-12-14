<?php

namespace App\Providers;

use App\Interfaces\ContactPersonRepositoryInterface;
use App\Interfaces\ProjectRepositoryInterface;
use App\Repositories\ContactPersonRepository;
use App\Repositories\ProjectRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(ProjectRepositoryInterface::class, ProjectRepository::class);
        $this->app->bind(ContactPersonRepositoryInterface::class, ContactPersonRepository::class);

    }
}
