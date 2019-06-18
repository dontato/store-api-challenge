<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Database\QueryException;

class PromoteToAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'store:admin:promote
        {--email= : The account email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Promote a user to admin';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (!($email = $this->option('email'))) {
            $email = $this->ask('What is the account\'s email?');
        }

        $user = (new User)->where('email', $email)->firstOrFail();
        $user->assignRole('admin');
    }
}
