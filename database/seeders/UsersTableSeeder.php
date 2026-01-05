<?php

namespace Database\Seeders;
use App\Constants\UserTypes;
use Illuminate\Database\Seeder;
use App\Models\User;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /** @var User $user */
        $user = User::factory()->create([
            'first_name' => 'Super',
            'last_name' => 'Admin',
            'email' => 'admin@lodex.com',
            'password' =>'102030',
            'active' => true,
            'type' => UserTypes::ADMIN
        ]);
        $user->groups()->attach(1);
        User::factory()->count(5)->create();
    }
}
