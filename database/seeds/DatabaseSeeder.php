<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Website;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Luiz Paulo',
            'email' => 'luiz@teclia.com',
            'password' => bcrypt('1234')
        ]);

        $teclia = Website::create([
            'owner_id' => $user->id,
            'name' => 'Teclia',
            'domain' => 'teclia.com',
            'subdomain' => 'teclia'
        ]);
    }
}
