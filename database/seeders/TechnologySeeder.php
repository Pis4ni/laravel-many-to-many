<?php

namespace Database\Seeders;

use App\Models\Technology;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class TechnologySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $labels = ["HTML","CSS","SCSS","JavaScript","PHP","Bootstrap","AXIOS","NodeJS","Laravel","SQL","GIT","Blade"];

        foreach($labels as $label) {
          $type = new Technology();
          $type->label = $label;
          $type->color = $faker->hexColor();
          $type->save();
        }
    }
}
