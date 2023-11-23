<?php

use App\Models\User;


if (! function_exists("newUser")) {
    function newUser($params = [], $count = NULL)
    {
        return User::factory($count)->create($params);
    }
}
