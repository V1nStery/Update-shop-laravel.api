<?php

namespace Database\Seeders;
use App\Models\User; //  Импортируй модель User
use App\Models\Role; //  Импортируй модель Role
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
        {
            // Найди роль, которая тебе нужна
            $role = Role::where('name', 'admin')->first(); //  Например, роль 'user'

            User::create([
                'name' => 'Admin',
                'email' => 'sasha_belosludcev@mail.ru',
                'password' => Hash::make('admin'), // Не забудь захешировать пароль!
                'role_id' => $role->id, // Вот тут указываешь id роли
            ]);
        }
}


