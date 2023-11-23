<?php

namespace App\Services;
use App\Actions\RegisterationAction;
use App\Traits\ApiResponseTrait;
use Illuminate\Support\Facades\DB;

class AuthenticationService
{
    use ApiResponseTrait;

    public function login($credentials)
    {
        try {
            if (!$token = auth('users')->attempt($credentials)) {
                return $this->respondUnAuthorized('Your Username/Password is Invalid!');
            }

            return $this->respond(['token' => $token]);

        } catch (\Exception $e) {
            $this->respondBadRequest($e->getMessage());
        }
    }

    public function store($request)
    {
        try {
            DB::beginTransaction();
            (new RegisterationAction($request))->execute() ;
            DB::commit();

            return $this->respondCreated();
        } Catch(\Exception $e) {
            DB::rollBack();
            return $this->respondBadRequest($e->getMessage());
        }
    }
}
