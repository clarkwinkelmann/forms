<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class CreateUserCommand extends Command
{
    protected $signature = 'forms:user';
    protected $description = 'Create a new user';

    public function handle()
    {
        $this->info('This command will create or update a user account.');
        $this->info('Submit "cancel" as the value to cancel anytime.');

        $email = $this->ask('Email address', '');

        if ($email == 'cancel') {
            $this->info('Cancelled.');
            return;
        }

        $user = User::where('email', $email)->first();

        if (is_null($user)) {
            $this->info('A new user account will be created.');
            $password = $this->secret('Choose a password');

            if ($password == 'cancel') {
                $this->info('Cancelled.');
                return;
            }

            $user = new User;
            $user->email = $email;
            $user->password = bcrypt($password);
            $user->save();

            $this->info('New user created.');
        } else {
            $this->info('Entering edit mode for this account.');
            $password = $this->secret('Choose a new password:');

            $user->password = bcrypt($password);
            $user->save();

            $this->info('User updated.');
        }
    }
}
