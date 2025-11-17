<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Post;
class ChildCount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'child-count';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $posts = Post::all();
        foreach($posts as $post){
            $count = Post::where('parent_id','=',$post['id'])->count();
             $post->view_count = rand(100,10000);
             $post->child_count = $count;
             $post->save();
        }
    }
}
