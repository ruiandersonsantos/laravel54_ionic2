<?php

namespace CodeFlix\Providers;

use CodeFlix\Models\User;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'CodeFlix\Model' => 'CodeFlix\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        /*
         * Aqui está definindo uma habilidade para verificar se o usuario é um admin ou não.
         * Usado para determinar as permissões de acesso a area administrativa do sistema.
         */
        \Gate::define('admin',function($user){
           return $user->role == User::ROLE_ADMIN;
        });

    }
}
