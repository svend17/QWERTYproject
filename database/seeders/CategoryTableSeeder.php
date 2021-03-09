<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['name' => 'IT'],
            ['name' => 'Music'],
            ['name' => 'Films']
        ];
        Category::insert($data);
    }
}
