<?php

use App\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = ['Front End', 'Back End', 'General', 'Vue'];
        foreach ($tags as $tag) {
          $newTag = new Tag();
          $newTag->name = $tag;
          $newTag->slug = Str::slug($tag, '-');
          $newTag->save();
        }
    }
}