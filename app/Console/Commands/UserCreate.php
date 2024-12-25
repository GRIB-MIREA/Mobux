<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class UserCreate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-user {name} {email} {password} {telegram_id} {role}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = $this->argument('name');
        $email = $this->argument('email');
        $password = $this->argument('password');
        $telegram_id = $this->argument('telegram_id');
        $role = $this->argument('role');

        User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'telegram_id' => $telegram_id,
            'role' => $role,
        ]);
    }
}
