<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create(['name' => 'un-categorized', 'slug' =>'un_categorized', 'status' => 1]);
        Category::create(['name' => 'Health and fitness', 'slug' =>'health_and_fitness', 'status' => 1]);
        Category::create(['name' => 'Fashion and beauty', 'slug' =>'fashion_and_beauty', 'status' => 1]);
        Category::create(['name' => 'Photography ', 'slug' =>'photography ', 'status' => 0]);
        Category::create(['name' => 'Music ', 'slug' =>'music ', 'status' => 0]);
        Category::create(['name' => 'Sports ', 'slug' =>'sports ', 'status' => 0]);
        Category::create(['name' => 'Political ', 'slug' =>'political ', 'status' => 0]);
    }
}
