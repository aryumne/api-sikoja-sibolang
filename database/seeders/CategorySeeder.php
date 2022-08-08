<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            "category" => "Pantai"
        ]);
        Category::create([
            "category" => "Sungai"
        ]);
        Category::create([
            "category" => "Genangan Air"
        ]);
        Category::create([
            "category" => "Tanah Longsor"
        ]);
    }
}
