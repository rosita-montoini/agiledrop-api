<?php

namespace App\Domains\Auth\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class LoginJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

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
        $user = User::where('email', $this->email)->first();
    
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Email not found'], 404);
        }

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
