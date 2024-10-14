<?php

namespace App\Domains\Auth\Jobs;

class LogoutJob
{
    protected $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
       return $this->user->currentAccessToken()->delete();
    }
}
