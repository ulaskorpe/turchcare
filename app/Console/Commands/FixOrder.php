<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Post;
class FixOrder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix-order';

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
        $cats = Post::where('type_id','=',5)->where('parent_id','=',0)->get();
        $j=1;
        foreach($cats as $cat){
            $i=1;
            $posts = Post::where('parent_id','=',$cat['id'])->get();
            foreach($posts as $post ){
                $post->count = $i;
                $post->save();
                $i++;
            }
            $cat->count = $j;
            $cat->save();
            $j++;

        }
    }
}
