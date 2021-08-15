<?php

use Illuminate\Database\Seeder;
use App\Models\Log;

class LogsSeeder extends Seeder
{
    protected $connection = 'mongodb';
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $logs = factory(Log::class, 20)->create();
    }
}
