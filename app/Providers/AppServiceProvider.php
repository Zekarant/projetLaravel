<?php

namespace App\Providers;
use App\Repositories\MatiereRepository;
use App\Repositories\ProfRepository;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        Blade::if('admin', function () {
            return auth()->check() && auth()->user()->admin;
        });

        Blade::if ('adminOrOwner', function ($id) {
            return auth()->check() && (auth()->id() === $id || auth()->user()->admin);
        });


        if (request ()->server ("SCRIPT_NAME") !== 'artisan') {
            view ()->share ('matieres', resolve(MatiereRepository::class)->getAll());
            view ()->share ('profs', resolve(ProfRepository::class)->getAll());
        }

        view ()->composer('layouts.app', function ($view)
        {
            if(auth()->check()) {
                $profs = resolve (ProfRepository::class)->getAll();
                if($profs->isNotEmpty()) {
                    $view->with('profs', $profs);
                }
            }
        });
    }
}
