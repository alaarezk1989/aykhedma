<?php

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
        $segmentations = factory( Segmentation::class,20)->create();
    }
}
