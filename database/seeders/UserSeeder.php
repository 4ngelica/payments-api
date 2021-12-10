<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Seeds 5 users with wallets
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory()->count(5)
        ->create()
        ->each(function ($user) {
          \App\Models\Wallet::factory()->count(1)->create(['user_id'=>$user->id]);
        });
    }
}
