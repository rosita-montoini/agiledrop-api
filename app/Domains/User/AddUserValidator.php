<?php
namespace App\Domains\User;

use Illuminate\Support\Facades\Validator;

class AddUserValidator
{
    protected $rules = [
        'email'     => 'required|email|exists:users,email',
        'password'  => 'required|string|min:8',
    ];

    /**
     * Validate the given input against the rules.
     *
     * @param array $input
     * @param array $messages Custom validation messages
     * @return bool
     */
    public function validateInput(array $input, array $messages = [])
    {
        $validator = Validator::make($input, $this->rules, $messages);

        return (bool)$validator->validate();
    }
}

