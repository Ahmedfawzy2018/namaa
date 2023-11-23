<?php

namespace App\Actions;

use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class RegisterationAction
{
    protected $request;

    public function __construct(RegisterUserRequest $request)
    {
        $this->request = $request->validated() ;
    }

    public function execute()
    {
        User::create($this->request);
    }
}
