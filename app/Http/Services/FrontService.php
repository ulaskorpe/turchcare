<?php

namespace App\Http\Services;
use App\Models\Post;
use App\Models\Type;
use App\Enums\Languages;
use Illuminate\Support\Str;
class FrontService
{



    public function getLanguages($keys=0){
        $langs = Languages::asArray();
        if(!$keys){
            return  $langs;

        }else{
            $keys = array_keys($langs);
            return $keys;
        }



    }

    public function splitText($text) {
        // $length = strlen($text);
        // $half = ceil($length / 2); // Get the middle index, rounded up

        // $part1 = substr($text, 0, $half);
        // $part2 = substr($text, $half);

        // return [$part1, $part2];
        $words = explode(' ', $text); // Split text into words
        $totalWords = count($words);
        $half = ceil($totalWords / 2); // Get middle index, rounded up

        $part1 = implode(' ', array_slice($words, 0, $half)); // First half
        $part2 = implode(' ', array_slice($words, $half));    // Second half

        return [$part1, $part2];
    }

    public function findType($slug){

        return Type::where('slug','=',$slug)->pluck('id')->first();


     }
     public function fetchData($array,$get=true){

        $type_array = Type::whereIn('slug',$array)->pluck('id')->toArray();

        if(is_array($array)){
        $data = Post::with('type')->whereIn('type_id',$type_array);
        }else{
            $data = Post::with('type')->where('type_id','=',$type_array);
        }
        $data= $data
        ->where('lang','=',session()->get('locale'))
        ->where('show_post','=',1) ;

   
        return ($get) ? $data->get() : $data;
     }

     public function getData($array,$limit=0,$faq_id= 0,$parent_id= 0,$orderBy=['count','asc']){

       $type_array = Type::whereIn('slug',$array)->pluck('id')->toArray();
       
        if(is_array($array)){
        $data = Post::with('type')->whereIn('type_id',$type_array);
        }else{
            $data = Post::with('type')->where('type_id','=',$type_array);
        }
        $data= $data
        ->where('lang','=',session()->get('locale'))
        ->where('show_post','=',1) ;
           if($faq_id){
               $data = $data->where('parent_id','=',$faq_id);
           }
           if($parent_id){
               $data = $data->where('parent_id','=',$parent_id);
           }
           $data = $data->orderBy($orderBy[0],$orderBy[1]);
           if( $limit >  0){
            $data = $data ->limit($limit);
   
           }
           return $data->get();
        }
        public function commonData( $array = []) {
   
             $posts = $this->fetchData($array);
             $data = [];
             foreach($posts as $post) {
                 //  $data[$]
             }
   
             return $data;
        }
     public function addSlug($data , $route_name=""){
        foreach($data as $item){

            $item->slug =  Str::slug($item->title);
            if($route_name != ''){
            $item->formatted_link = $route_name.'/'.$item->slug.'/'.$item->id;

            }
        }
        return $data;
     }



     public function getOne($type){
        $data = $data =    Post::where('type_id','=',$type)
        ->orWhere('slug','=',$type)
        ->where('lang','=',session()->get('locale'))
        ->where('show_post','=',1)->first();
        return $data;
     }

}