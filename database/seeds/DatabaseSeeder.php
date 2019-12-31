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
            'name' => 'Developer1',
            'username' => 'Developer1',
            'email' => 'developer1@contoso.com',
            'password' => bcrypt('Qwerty78'),
            'status' => Shared::STATUS_ACTIVE,
            'sort' => Shared::DEFAULT_SORT,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        DB::table('users')->insert([
            'name' => 'Developer2',
            'username' => 'Developer2',
            'email' => 'developer2@contoso.com',
            'password' => bcrypt('Qwerty78'),
            'status' => Shared::STATUS_ACTIVE,
            'sort' => Shared::DEFAULT_SORT,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        DB::table('users')->insert([
            'name' => 'Developer3',
            'username' => 'Developer3',
            'email' => 'developer3@contoso.com',
            'password' => bcrypt('Qwerty78'),
            'status' => Shared::STATUS_ACTIVE,
            'sort' => Shared::DEFAULT_SORT,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        DB::table('users')->insert([
            'name' => 'Developer4',
            'username' => 'Developer4',
            'email' => 'developer4@contoso.com',
            'password' => bcrypt('Qwerty78'),
            'status' => Shared::STATUS_ACTIVE,
            'sort' => Shared::DEFAULT_SORT,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        DB::table('users')->insert([
            'name' => 'Developer5',
            'username' => 'Developer5',
            'email' => 'developer5@contoso.com',
            'password' => bcrypt('Qwerty78'),
            'status' => Shared::STATUS_ACTIVE,
            'sort' => Shared::DEFAULT_SORT,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        DB::table('users')->insert([
            'name' => 'Developer6',
            'username' => 'Developer6',
            'email' => 'developer6@contoso.com',
            'password' => bcrypt('Qwerty78'),
            'status' => Shared::STATUS_ACTIVE,
            'sort' => Shared::DEFAULT_SORT,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        DB::table('users')->insert([
            'name' => 'Developer7',
            'username' => 'Developer7',
            'email' => 'developer7@contoso.com',
            'password' => bcrypt('Qwerty78'),
            'status' => Shared::STATUS_ACTIVE,
            'sort' => Shared::DEFAULT_SORT,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        DB::table('users')->insert([
            'name' => 'Developer8',
            'username' => 'Developer8',
            'email' => 'developer8@contoso.com',
            'password' => bcrypt('Qwerty78'),
            'status' => Shared::STATUS_ACTIVE,
            'sort' => Shared::DEFAULT_SORT,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        DB::table('users')->insert([
            'name' => 'Developer9',
            'username' => 'Developer9',
            'email' => 'developer9@contoso.com',
            'password' => bcrypt('Qwerty78'),
            'status' => Shared::STATUS_ACTIVE,
            'sort' => Shared::DEFAULT_SORT,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
