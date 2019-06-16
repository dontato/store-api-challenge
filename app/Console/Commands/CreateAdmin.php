<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Database\QueryException;

class CreateAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'store:admin:create
        {--name= : The user\'s name}
        {--email= : The account email}
        {--password= : The account email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new user and create admin role';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $user = new User;

        if (!($name = $this->option('name'))) {
            $name = $this->ask('What is the user\'s name?');
        }

        if (!($email = $this->option('email'))) {
            $email = $this->ask('What is the account\'s email?');
        }

        if (!($password = $this->option('password'))) {
            $password = $this->secret('What is the account\'s password?');
        }

        $user->name     = $name;
        $user->email    = $email;
        $user->password = bcrypt($password);

        try {
            $user->save();
            $user->assignRole('admin');
        } catch (QueryException $e) {
            $this->error(
                'There is another user account associated to that email account'
            );
        }
    }
}
