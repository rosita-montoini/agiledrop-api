<?php

namespace App\Domains\User\Jobs;

use App\Domains\User\AddUserValidator;
use Illuminate\Validation\ValidationException;

class ValidateAddUserInputJob
{
    protected $input;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $input)
    {
        $this->input = $input;
    }

    /**
     * Execute the job.
     *
     * @return bool
     */
    public function handle(AddUserValidator $validator)
    {
        $validation = $validator->validateInput($this->input);

        if ($validation->fails()) {
            throw new ValidationException($validation);
        }
    }
}