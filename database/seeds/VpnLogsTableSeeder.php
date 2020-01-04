<?php

use App\Entity\VpnLog;
use Illuminate\Database\Seeder;

class VpnLogsTableSeeder extends Seeder
{
    public function run(): void
    {
        factory(VpnLog::class, 150)->create();
    }
}
