<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();


        Gate::define('gate', function (User $user) {

            $flag = false;
            foreach ($user->roles as $value) {
                if ($value->name == 'Administrator') {
                    $flag = true;
                } else {
                    $flag = false;
                }
            }

            if ($flag == true) {
                return true;
            } else {
                return false;
            }
        });
    }
}
