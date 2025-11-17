<?php

namespace App\Observers;
use App\Models\Type;
use App\Models\Post;
use App\Enums\Languages;
class TypeObserver
{
    public function created(Type $type){

        $keys = array_keys(Languages::asArray());

        foreach($keys as $key){
           $post = Post::where('lang','=',$key)->where('type_id','=',$type->id)->first();
           if(empty($post)){
            Post::create([
                'title'=>$type['name'],
                'type_id'=>$type['id'],
                'lang'=>$key,
                'count'=>1
            ]);
           }
        }

    }
}
