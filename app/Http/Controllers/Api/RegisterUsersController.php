<?php

namespace CodeFlix\Http\Controllers\api;

use CodeFlix\Repositories\UserRepository;
use Illuminate\Http\Request;
use CodeFlix\Http\Controllers\Controller;
use Laravel\Socialite\Two\User;


class RegisterUsersController extends Controller
{
    private $repository;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }


    /**
     * @param Request $request
     */
    public function store(Request $request)
    {
        $authorization = $request->header('Authorization');

        $acessToken = str_replace('Bearer','',$authorization);

        $facebook = \Socialite::driver('facebook');

        /** @var User $userSocial */
        $userSocial = $facebook->userFromToken($acessToken);

        $user = $this->repository->findByField('email', $userSocial->email)->first();

        if(!$user){
            \CodeFlix\Models\User::unguard();
            $user = $this->repository->create([
                'name' => $userSocial->name,
                'email' => $userSocial->email,
                'role' => \CodeFlix\Models\User::ROLE_CLIENT,
                'verified' => true
            ]);
            \CodeFlix\Models\User::reguard();
        }

        return ['token' => \Auth::guard('api')->tokenById($user->id)];
    }
}
