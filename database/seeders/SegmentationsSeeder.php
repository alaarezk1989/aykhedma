<?php

namespace Database\Seeders;
    use App\Models\Segmentation;
    use Faker\Factory;
    use Illuminate\Database\Seeder;
class SegmentationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $segmentations = Segmentation::factory()->count(20)->create();
    }
}
