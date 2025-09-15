<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Password;

class TestPasswordReset extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:password-reset {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test password reset functionality';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');

        // Check if user exists
        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error("User with email {$email} not found!");
            $this->info("Available users:");
            User::all(['email', 'name'])->each(function ($u) {
                $this->line("- {$u->email} ({$u->name})");
            });
            return;
        }

        $this->info("User found: {$user->name} ({$user->email})");

        // Test password reset
        $this->info("Attempting to send password reset link...");

        $status = Password::sendResetLink(['email' => $email]);

        $this->info("Status: {$status}");

        if ($status == Password::RESET_LINK_SENT) {
            $this->info("✅ Password reset link sent successfully!");
        } else {
            $this->error("❌ Failed to send password reset link");
            $this->error("Error: " . __($status));
        }
    }
}
