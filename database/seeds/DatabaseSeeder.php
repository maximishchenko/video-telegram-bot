<?php

use App\Shared;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Developer',
            'email' => 'developer@contoso.com',
            'password' => bcrypt('Qwerty78'),
            'status' => Shared::STATUS_ACTIVE,
            'sort' => Shared::DEFAULT_SORT,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
