<?php

namespace Database\Seeders;
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
        $logs = Log::factory()->count(20)->create();
    }
}
