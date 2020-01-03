<?php


use App\Entity\VpnGroups;
use Illuminate\Database\Seeder;

class VpnGroupsTableSeeder extends Seeder
{
    public function run(): void
    {
        factory(VpnGroups::class, 50)->create();
    }
}
