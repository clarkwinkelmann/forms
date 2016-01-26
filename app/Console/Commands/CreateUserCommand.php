<?php namespace App\Console\Commands;

/**
 * Forms, a simple WWW form handler as-a-service
 * @copyright (c) 2016 Clark Winkelmann
 * @license MIT
 */

use App\User;
use Illuminate\Console\Command;

class CreateUserCommand extends Command {

	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'forms:user';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Create a new user';

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{
		$this->info('This command will create or update a user account.');
		$this->info('Submit "cancel" as the value to cancel anytime.');

		$email = $this->ask('Email address', '');

		if($email == 'cancel') {
			$this->info('Cancelled.');
			return;
		}

		$user = User::where('email', $email)->first();

		if(is_null($user)) {
			$this->info('A new user account will be created.');
			$password = $this->secret('Choose a password');

			if($password == 'cancel') {
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
