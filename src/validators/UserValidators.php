<?php

namespace App\validators;

use Valitron\Validator;

class UserValidators
{

    public static function validateUserRegistration($data): Validator
    {
        $validator = new Validator($data);
        $validator->rule('required', ['name', 'email', 'password']);
        $validator->rule('email', 'email');
        $validator->rule('lengthMin', 'password', 8);

        return $validator;
    }

    public static function validateUserLogin($data): Validator
    {
        $validator = new Validator($data);
        $validator->rule('required', ['email', 'password']);

        return $validator;
    }
}