<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class AddUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $f_name = readline('Ввведите имя пользователя: ');
        $l_name = readline('Ввведите фамилию пользователя: ');
        $email = readline('Ввведите email: ');
        $pass = readline('Ввведите пароль: ');

        $user = new User();
        $user->first_name = $f_name;
        $user->last_name = $l_name;
        $user->email = $email;
        $user->password = Hash::make($pass);

        if ($user->save()){
            echo 'Пользователь создан';
        }
    }
}
