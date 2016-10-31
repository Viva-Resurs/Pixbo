<?php

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
        DB::table('category')->delete();

        $category = Category::create([
            'id' => 1,
            'name' => config('pixbo.settings.category.default_name'),
            'user_id' => 1
        ]);

    }
}
