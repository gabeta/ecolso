<?php

namespace Domain\Users\Actions;

use Domain\Users\DataTransferObjects\CreateUserData;
use Domain\Users\Models\User;
use Illuminate\Auth\Events\Registered;

class RegisteredUser
{
    public function __invoke(CreateUserData $data): User
    {
        event(new Registered($user = User::create([
            'name' => $data->name,
            'email' => $data->email,
            'password' => bcrypt($data->password)
        ])));

        return $user;
    }
}
