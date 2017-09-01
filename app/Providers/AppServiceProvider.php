<?php

namespace CodeFlix\Providers;

use Dingo\Api\Exception\Handler;
use CodeFlix\Models\Video;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\ValidationException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Video::updated(function($video){
            if(!$video->completed){
                if($video->file != null &&
                    $video->thumb != null &&
                    $video->duration != null)
                {

                    $video->completed = true;
                    $video->save();
                }
            }

        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() !== 'prod') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }

        $this->app->bind(
            'bootstrapper::form',
            function ($app) {
                $form = new Form(
                    $app->make('collective::html'),
                    $app->make('url'),
                    $app->make('view'),
                    $app['session.store']->token()
                );

                return $form->setSessionStore($app['session.store']);
            },
            true
        );

        $handler = app(Handler::class);
        $handler->register(function(AuthenticationException $exception){
            return response()->json(['error' => 'Unauthenticated'],401);
        });

        $handler->register(function(JWTException $exception){
            return response()->json(['error' => $exception->getMessage()],401);
        });


        $handler->register(function(ValidationException $exception){
            return response()->json([
                'error' => $exception->getMessage(),
                'validation_error' => $exception->validator->getMessageBag()->toArray()
            ],422);
        });


    }
}
