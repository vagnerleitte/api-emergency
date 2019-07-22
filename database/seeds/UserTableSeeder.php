<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class)->create(
            [
                'name' => 'Leiviton Carlos',
                'email' => 'leivitoncs@gmail.com',
                'role' => 'admin',
                'status' => 'ativo',
                'cpf' => '08967095660',
                'password' => bcrypt(123456),
                'remember_token' => str_random(10),
            ]);

        factory(User::class)->create(
            [
                'name' => 'Vagner Silva',
                'email' => 'vagnerleitte@outlook.com',
                'role' => 'admin',
                'status' => 'ativo',
                'cpf' => '08967095661',
                'password' => bcrypt(123456),
                'remember_token' => str_random(10),
            ]);
    }
}
