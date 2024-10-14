<?php

namespace App\Domains\Auth\Jobs;

use Illuminate\Support\Facades\Auth;

class LoginJob
{
    protected $email;
    protected $password;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email, $password)
    {
        $this->email = $email;
        $this->password = $password;
    }

    /**
     * Execute the job.
     *
     * @return array
     */
    public function handle()
    {
        if (!Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            return response()->json(['success' => false, 'message' => 'Invalid credentials'], 401);
        }
    
        $user = Auth::user();
        
        $token = $user->createToken('API Token')->plainTextToken;
    
        return response()->json([
            'success' => true,
            'token' => $token,
            'user' => $user,
        ]);
    }
}
