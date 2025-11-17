<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Faker\Factory as Faker;

//use Illuminate\Support\Facades\App;
use App\Traits\HttpResponses;
//use Illuminate\Support\Facades\Mail;

use App\Models\Post;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
class FrontController extends Controller
{

    use HttpResponses;
    private $faker ;

    public function test(){
        return view('front.temp');
    }





    public function __construct() {
        $this->faker = Faker::create();
    }

     public function home(){
        


 
        if(empty(session()->get('locale'))){
            session()->put('locale','tr');
        }
        $array = [
        'slider'=>42,
        'categories'=>5,
   
        ];

        $posts = $this->getData($array);
       
        $sliders  = [];
      
        $categories  = [];


        foreach($posts as $post){
            switch ($post['type_id']) {

               case 42:
               if ($post['product_id'] > 0) {
                $product = Post::find($post['product_id']);
                if ($product) {
                    $post['product'] = $product;
                }
              }
                 $sliders[] = $post;
               break;
              case 5:
                    $categories = $post;
                break;
        




            }

        }

       //dd($sliders);
 
        return view('front.home',  compact('sliders'));
     }

     public function setLanguage($locale) {

        if (in_array($locale, ['en', 'tr','de'])) {

          // session()->put('locale',$locale);
           //session()->put('selectedLang',$locale);
            Session::put('locale',$locale);

        }


        return redirect()->back();

     }


     private function addSlug($data , $route_name=""){
        foreach($data as $item){

            $item->slug =  Str::slug($item->title);
            if($route_name != ''){
            $item->formatted_link = $route_name.'/'.$item->slug.'/'.$item->id;

            }
        }
        return $data;
     }

     private function getOne($type){
        $data = $data =    Post::where('type_id','=',$type)->where('lang','=',session()->get('locale'))
        ->where('show_post','=',1)->first();
        return $data;
     }

     private function fetchData($array){
        if(is_array($array)){
        $data = Post::whereIn('type_id',$array);
        }else{
            $data = Post::where('type_id','=',$array);
        }
        $data= $data
        ->where('lang','=',session()->get('locale'))
        ->where('show_post','=',1);

        return $data;
     }
     private function getData($array,$limit=0,$faq_id= 0,$parent_id= 0){

     $data = $this->fetchData($array);
        if($faq_id){
            $data = $data->where('parent_id','=',$faq_id);
        }
        if($parent_id){
            $data = $data->where('parent_id','=',$parent_id);
        }

        if( $limit >  0){
            $data = $data->orderBy('count')->limit($limit)->get();

        }else{
           $data = $data->orderBy('count')->get();


        }
        return $data;
     }
     private function commonData( $array = []) {
        if(count($array) == 0){
        $array = [
            7,44,45,48,10

          ];
        }
          $posts = $this->getData($array);
          $data = [];
          foreach($posts as $post) {
              switch ($post['type_id']) {
              case 7;
                  $data['about_us'] = $post;
                  $data['about_us']['text'] =$this->splitText( $post->title);
              break ;
              case 45;
              $data['about_us_icons'][] = [
                  'title'=>$post['title'],
                  'image'=> $post['image'],
                  'link'=> $post['link']
              ];



              break;

              case 46;
              $txt = $this->splitText($post['title']);
              $data['services_spot'] = [
                  'title_1'=>$txt[0],
                  'title_2'=>$txt[1],
              ];
              break;

              case 8 ; ///services
              $data['services'][] = $post;
            //   $data['services'][] = [
            //     'id'=>$post['id'],
            //     'title'=>$post['title'],
            //     'slug'=> Str::slug( $post['title']),
            //     'prologue'=>$post['prologue'],
            //     'image'=>$post['image']
            // ];
              break;


               case 10;
              $data['choose_us'][] = $post['title'];
              break;
              case 52;
              $data['health_tourism'] = $post ;
              break;

              case 48;
              $txt = $this->splitText($post['title']);
              $data['choose_us_spot'] = [
                  'title_1'=>$txt[0],
                  'title_2'=>$txt[1],
              ];
              break;

              case 44; ///referanslar -- testimonials
              $txt = $this->splitText($post['title']);
              $data['testimonials'] = [

                  'title'=>$txt[0],
                  'title_2'=>$txt[1],
                  'text'=>$post['second_title'],
                  'link'=>$post['link'],
                  'image'=>$post['image'],
                  'second_image'=>$post['second_image']
              ];
              break;

              case 50;
              $data['ref_icons'][] = [
                'image'=>$post['image'],
                'title'=>$post['title'],
                'prologue'=>$post['prologue'],
              ];
              break;
              case 51;
              $data['faq_cats'][] = $post ;
              break;

              }
          }

          return $data;
     }
     public function aboutUs () {
        $data = $this->commonData();

        $title = $this->splitText($data['about_us']['title']);
        $title_2 = $this->splitText($data['about_us']['second_title']);

        $ref_icons = $this->getData([50]);

        return view('front.about_us',['about_us'=>$data['about_us'],'title_1'=>$title,'title_2'=>$title_2
        ,'about_us_icons'=>$data['about_us_icons']

        ,'choose_us_spot'=>$data['choose_us_spot']
        ,'choose_us'=>$data['choose_us']
        ,'testimonials'=>$data['testimonials']
        ,'ref_icons'=>$ref_icons
        ,'title'=>__('front.about_us')


    ]);
     }


     public function treatmentDetail ($slug,$id) {
        $treatment = Post::find($id);

        $spot  = $this->getOne(3);
        $faqs_spot = $this->getOne(47);

        $faqs_spot =
        [
            'title'=> $this->splitText($faqs_spot['title']),
            'image'=>$faqs_spot['image']
        ];

        $faqs = [];
        if($treatment['faq_id']){
            $faqs = $this->getData([9],0,$treatment['faq_id']) ;

        }
        $data = $this->commonData([10,48,44,50]);

        return view('front.treatment_detail',[ 'treatment'=>$treatment
        ,'title'=>__('front.treatments').'-'.$treatment->title
        ,'youtube_video' => ( $treatment->priority =='youtube_video' ) ? true : false

        ,'appointment_spot'=>$spot['prologue']
        ,'appointment_txt'=>$this->splitText($spot['title'])
        ,'appointment_title'=>$treatment['title'].'--'.session()->get('locale')
        ,'faqs'=> $faqs //    $this->getData([9],4)
        ,'faqs_spot'=>$faqs_spot
        ,'choose_us'=>$data['choose_us']
        ,'choose_us_spot'=>$data['choose_us_spot']
        ,'testimonials'=>$data['testimonials']
        ,'ref_icons'=>$data['ref_icons']

        ] );

     }
     public function treatments  () {



        return view('front.treatments',[ 'treatments'=>$this->addSlug( $this->getData([4]))
        ,'title'=>__('front.treatments')


    ]);
     }

     public function healthTourism() {
        $data = $this->commonData([8,10,48,52,46,44,50]);

       $health_tourism = $data['health_tourism'];

        $head_title = $this->splitText($health_tourism['title']);
        $step_1_title = $this->splitText($health_tourism['second_title']);
        $step_2_title = $this->splitText($health_tourism['third_title']);

        $choose_us = $data['choose_us'];

        $choose_us_spot = $data['choose_us_spot'];
        $ref_icons = $data['ref_icons'];

        $services = $this->addSlug( $data['services']);

        $services_spot = $data['services_spot'];
        $testimonials = $data['testimonials'];

        $title = __('front.health_tourism');


        $faqs_spot= $this->getOne(47);

        $faqs_spot =
        [
            'title'=> $this->splitText($faqs_spot['title']),
            'image'=>$faqs_spot['image']
        ];

        $faqs = [];
        if($health_tourism['faq_id']){
            $faqs = $this->getData([9],0,$health_tourism['faq_id']) ;

        }


        $appointment_spot = $health_tourism['prologue'];
       $appointment_txt= $this->splitText($health_tourism['title']);
        $appointment_title= 'health tourism - '.session()->get('locale');

        return view('front.health_tourism', compact('health_tourism','title','head_title','step_1_title','step_2_title','choose_us','choose_us_spot','services','services_spot','testimonials','ref_icons','faqs_spot','faqs','appointment_spot','appointment_txt','appointment_title'));
    }

    public function videos ( ){

        $videos  = Post::whereNotNull('youtube_video')
        ->where('lang','=',session()->get('locale'))
        ->where('show_post','=',1)
        ->orderBy('created_at','desc')->get();

        return view('front.videos', ['title'=>__('front.media')."/".__('front.videos'),'videos'=>  $videos]);
    }
    public function contactUs ($subject="" ){
        return view('front.contact', [

            'title'=>__('front.contact_us')
            ,'subject'=> $subject
            ,'get_in_touch'=> $this->splitText(__('front.get_in_touch'))
            ,'send_message'=> $this->splitText(__('front.contact_page.send_message'))
        ]);
    }
    public function faqPage (){
        $faq_cats = $this->commonData([51])['faq_cats'] ;
        $faqs_array = [];

        foreach($faq_cats as $faq_cat){

            $faqs_array[] = [
                'title'=>$this->splitText($faq_cat['title']),
                'faqs'=>$this->getData([9],0,0,$faq_cat['id'])

            ];
        }



         return view('front.faq', ['title'=>__('front.sss'),'faqs_array'=> $faqs_array,'others'=>$this->getData([9],0,0,0)]);


    }

    public function blogs  (){


        return view('front.blogs', ['title'=>__('front.blogs'),'blogs'=> $this->addSlug( $this->getData([13]),'blogs')]);
    }


    public function blogDetail ( $slug,$id){

        $blog = Post::find($id);

        if($blog['type_id']!=13){
            return redirect()->back();
        }


        $data = $this->commonData([10,48,44,50]);

        return view('front.blog_detail',[ 'blog'=>$blog
        ,'title'=>__('front.blogs').'-'.$blog->title
        ,'youtube_video' => ( $blog->priority =='youtube_video' ) ? true : false
        ,'similar_ones'=> $this->addSlug( $this->fetchData(13)->where('id', '!=', $id)->inRandomOrder()
        ->limit(3)->get(),'/blogs')

        ,'similar_posts'=>$this->splitText(__('front.similar_posts'))



        ] );
    }

    public function serviceDetail  ( $slug,$id ) {
        $service = Post::find($id);


        if($service['type_id']!=8){
            return redirect()->back();
        }



        return view('front.service_detail',[ 'service'=>$service
        ,'title'=>__('front.our_services').'-'.$service->title
        ,'youtube_video' => ( $service->priority =='youtube_video' ) ? true : false
        ,'others'=> $this->addSlug( $this->fetchData(8)->orderBy('count')->get(),'/services')

        ,'similar_posts'=>$this->splitText(__('front.similar_posts'))



        ] );

    }
}
