<?php
namespace App\Domains\Image;

use Illuminate\Support\Facades\Validator;

class NewImageValidator
{
    protected $rules = [
        'title'         => 'required|string|max:255',
        'description'   => 'nullable|string|max:1000',
        'image'         => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
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

