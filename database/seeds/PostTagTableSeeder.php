<?php

use App\Post;
use App\Tag;
use Illuminate\Database\Seeder;

class PostTagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      // popolo la tabella ponte con 30 tag
       for($c = 0; $c < 30; $c++){
        $post = Post::inRandomOrder()->first();
        $tagID = Tag::inRandomOrder()->first()->id;
        $post->tags()->attach($tagID);
       }
    }
}
