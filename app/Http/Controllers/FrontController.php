<?php

namespace App\Http\Controllers;

use App\Http\Services\FrontService;
use Illuminate\Http\Request;
use Faker\Factory as Faker;

//use Illuminate\Support\Facades\App;
use App\Traits\HttpResponses;
//use Illuminate\Support\Facades\Mail;

use App\Models\Post;
use App\Models\Type;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use App\Mail\ContactMail;
use Illuminate\Support\Facades\Mail;
use App\Models\Comment;
use Carbon\Carbon;

class FrontController extends Controller
{

    use HttpResponses;

    public function test(){



        // $ip = '94.120.125.21';//request()->ip();
        // $response = file_get_contents("http://ip-api.com/json/{$ip}?fields=status,message,country,regionName,city,lat,lon,query");
        // $data = json_decode($response, true);

        // if ($data['status'] === 'success') {
        //     echo "Country: " . $data['country'] . "<br>";
        //     echo "City: " . $data['city'] . "<br>";
        // } else {
        //     echo "Error: " . $data['message'];
        // }
        return view('front.test');
    }

    private $service ;

    private $faker ;

    public function __construct(FrontService $frontService) {
        $this->faker = Faker::create();
        $this->service =  $frontService;
    }

    public function setLanguage($locale) {

        if (in_array($locale, ['en', 'tr','de'])) {

          // session()->put('locale',$locale);
           //session()->put('selectedLang',$locale);
            Session::put('locale',$locale);
        }
        return redirect()->back();

     }





    public function home(){


        if(empty(session()->get('locale'))){
            session()->put('locale','tr');
        }
        $sliders = Post::where('type_id','=',42)
        ->where('lang','=', session()->get('locale'))
        ->where('show_post','=','1')
        ->orderBy('count')
        ->get();
        $quote = Post::where('type_id','=',55) ->where('lang','=', session()->get('locale'))
        ->where('show_post','=','1')->inRandomOrder()->first();

        $active = 'home';

        return view('front.home',  compact('sliders'   ,'active','quote' ));
     }


     public function blogs(  $page=0 ){

        $blogs = $this->service->fetchData(['blogs'],false);

        // if(!empty($keyword) && $keyword!='all'){
        //     $blogs = $blogs->where(function($query) use ($keyword) {
        //         $query->where('title', 'like', "%$keyword%")
        //               ->orWhere('content', 'like', "%$keyword%");
        //     });
        // }

        $per_page=12;
        $page_count = (int) ceil($blogs->count() / $per_page);
        $blogs = $blogs->orderBy('created_at','desc')->skip($page*$per_page)->limit($per_page)->get();

         $active = 'blogs';
         $link = 'blogs';

           return view('front.blogs',
           compact('blogs' ,'active','link','page'   ,'page_count'));

     }

     public function gallery_detail ($slug,$id){
        $gallery = Post::where('id','=',$id)->first();
        $items = Post::where('parent_id','=',$gallery['id'])->where('show_post','=',1)->orderBy('count')->get();
$title = $gallery['title'];
$description = $gallery['description'];
$keywords = $gallery['keywords'];
$active = 'gallery';
$gallery->increment('view_count',1);

 return view('front.gallery_detail',compact('gallery','active','items','title','description','keywords'));

}

     public function blogDetail($slug,$id){
        $image_array = ['image','second_image','third_image','forth_image','fifth_image'];
            $blog = Post::where('id','=',$id)->first();
    $title = $blog['title'];
    $description = $blog['description'];
    $keywords = $blog['keywords'];
    $active='blogs';
    $comments = Comment::where('blog_id','=',$id)->where('show_comment','=',1);
        $count = $comments->count();
$comments = $comments->get();
$blog->increment('view_count',1);

$shareUrl = urlencode('https://esrinozguler.com/blogs/'.Str::slug($blog['title']).'/'.$blog['id']);
$shareTitle = urlencode($blog['title']);

$others = Post::where('type_id','=',13)
->where('id','<>',$id)
->where('show_post','=',1)->where('lang','=',session()->get('selectedLang'))->inRandomOrder()->limit(3)->get();
        $date = Carbon::parse($blog['created_at'])->format('d.m.Y');
    return view('front.blog_detail',compact('blog','active','title','description'
    ,'comments','count','date'
    ,'shareUrl','shareTitle','others'
    ,'keywords','image_array'));

}


public function videos($page=0){
    $videos = Post::whereNotNull('youtube_video')
    //->where('lang','=',session()->get('selectedLang'))
    ->where('show_post','=',1) ;


    $per_page=12;
    $page_count = (int) ceil($videos->count() / $per_page);
    $videos = $videos->orderBy('count')->skip($page*$per_page)->limit($per_page)->get();
    $active = 'videos';
    $link = 'videos';

    return view('front.videos',compact('videos','link','active','page'   ,'page_count'));

}
public function galleries($page=0){
    $galleries = Post::where('type_id','=',5)
    ->where('lang','=',session()->get('selectedLang'));
    //->get();

    $per_page=12;
    $page_count = (int) ceil($galleries->count() / $per_page);
    $galleries = $galleries->orderBy('count')->skip($page*$per_page)->limit($per_page)->get();
    $link = 'galeriler';
    $active = 'gallery';

    return view('front.gallery',compact('galleries','link','active','page'   ,'page_count'));

}

//{cat_id?}/{keyword?}/{page?}/{order?}
public function aboutUs(){
    $about_us = Post::where('type_id','=',$this->service->findType('about_us'))
    ->where('lang','=',session()->get('selectedLang'))
    ->first();
    $title = $about_us['title'];
    $description = $about_us['description'];
    $keywords = $about_us['keywords'];


    $active = 'about';
    $experiences =   Post::where('type_id','=',$this->service->findType('experiences'))
    ->where('lang','=',session()->get('selectedLang'))
    ->where('show_post','=',1)
    ->orderBy('count')
    ->get();
    return view('front.about_us',compact('about_us','experiences','title','description','keywords','active'));

}

function contactUs(){
    $slut = Post::where('type_id','=',46)
    ->where('lang','=',session()->get('selectedLang'))
    ->first();
    $title = $slut['title'];
    $description = $slut['description'];
    $keywords = $slut['keywords'];
    $active = 'contact';
    return view('front.contact',compact('slut','title','description','keywords','active'));
}







}
