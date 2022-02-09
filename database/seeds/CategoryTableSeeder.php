<?php

use App\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = ['CSS', 'JS', 'HTML'];
        foreach ($data as $item) {
          $newCat = new Category();
          $newCat->name = $item;
          $newCat->slug = Str::slug($newCat->name, '-');
          $newCat->save();
        }
    }
}