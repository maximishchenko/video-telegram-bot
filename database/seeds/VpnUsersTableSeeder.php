<?php


use App\Entity\VpnUsers;

class VpnUsersTableSeeder extends \Illuminate\Database\Seeder
{
    public function run(): void
    {
        factory(VpnUsers::class, 150)->create();
    }
}
