<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\ { Cours, User, Prof };
use App\Policies\ { CoursPolicy, UserPolicy, ProfPolicy };

class AuthServiceProvider extends ServiceProvider
{

    protected $policies = [
        Cours::class => CoursPolicy::class,
        User::class => UserPolicy::class,
        Prof::class => ProfPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
