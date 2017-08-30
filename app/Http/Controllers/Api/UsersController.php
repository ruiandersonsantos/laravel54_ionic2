<?php

namespace CodeFlix\Http\Controllers\api;

use CodeFlix\Http\Requests\UserSettingRequest;
use CodeFlix\Repositories\UserRepository;
use Illuminate\Http\Request;
use CodeFlix\Http\Controllers\Controller;

class UsersController extends Controller
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

    public function updateSettings(UserSettingRequest $request){

        $data = $request->only('password');
        $this->repository->update($data,$request->user('api')->id);

        return $request->user('api');
    }
}
