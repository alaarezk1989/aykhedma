<?php

    use App\Models\Point;
    use Faker\Factory;
    use Illuminate\Database\Seeder;

class UserPointsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $points = factory(Point::class, 200)->create();
    }
}
