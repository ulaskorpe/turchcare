<?php

namespace App\Observers;

use App\Models\Post;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
class PostObserver
{
    public function created(Post $post){
        if($post['count']>0){
        Post::where('lang', '=', $post['lang'])
        ->where('type_id', '=', $post['type_id'])
        ->where('parent_id', '=', $post['parent_id'])
        ->where('id', '<>', $post['id'])
        ->where('count', '>=', $post['count'])
        ->increment('count', 1);
        }
    }

    public function saved(Post $post){

        if(empty($post['third_title'])){
                Post::where('id','=',$post['id'])->update(['third_title'=>Str::slug($post['title'])]);
        }

        if($post->isDirty('count')){
//          $old_count = $post->getOriginal('count');


            // if($post['count'] > $old_count){ // new> old
            //     Post ::where('id', '!=', $post['id'])
            //         ->where('type_id','=',$post['type_id'])
            //         ->where('lang','=',$post['lang'])
            //         ->where('count','>',$old_count)
            //         ->where('count','<=',$post['count'])
            //         ->decrement('count',1);
            // }else{
            //     Post::where('id', '!=', $post['id'])
            //         ->where('lang','=',$post['lang'])
            //         ->where('type_id','=',$post['type_id'])
            //         ->where('count','>=',$post['count'])
            //         ->where('count','<',$old_count)
            //         ->increment('count',1);


            // }



            }
    }

}
