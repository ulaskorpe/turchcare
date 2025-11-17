<?php

namespace App\Http\Controllers;

use App\Enums\Languages;
use App\Http\Controllers\Helpers\GeneralHelper;
use App\Models\Contact;
use Faker\Factory as Faker;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Post;
use Illuminate\Support\Str;
use App\Models\Type;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Mail;
use App\Mail\LeadAssigned;
use Illuminate\Support\Facades\Log;
use Exception;
use App\Models\SysLog;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\DB;
class HomeController extends Controller
{
    use HttpResponses;
    private $faker ;

    public function __construct() {
        $this->faker = Faker::create();
    }

    public function sysLog($key=null){
        $clientIp =  $_SERVER['REMOTE_ADDR'] ;// $request->ip(); // Kullanıcının IP adresi
    //   appSysLog('incomingMessage', $clientIp ,json_encode(  $clientIp, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        if (in_array($clientIp, ['192.168.56.1', '213.74.71.139','94.120.123.72'])) {
        // if ($clientIp === '192.168.56.1') {

                $data = SysLog::where('title','LIKE','%'.$key.'%')
                ->orWhere('type','LIKE','%'.$key.'%')
                ->orWhere('data','LIKE','%'.$key.'%')
                ->orderBy('id','DESC')->limit(100)->get();

            // Sadece bu IP için çalışacak kısım
            // return response()->json([
            //     'status' => 'ok',
            //     'message' => 'İzin verilen IP: ' . $clientIp,
            // ]);
            return view('sys_log_list',compact('data'));
        }

        // Diğer IP’ler için
        return response()->json([
            'status' => 'forbidden',
            'message' => 'Bu işlem için yetkiniz yok. IP: ' . $clientIp,
        ], 403);
    }


    public function sendGet(){

        //Log::channel('data_check')->info("Received Request: " . json_encode($request->all()));

        ///  Mail::to($request['email'])->send(new LeadAssigned($request['text'], $request['subject']));
          Mail::to('ulaskorpe@gmail.com')->send(new LeadAssigned("thats a messaage", "ffsafssfsdfsdfsdf"));

    }


public function sendEmail(Request $request){

   try {

    Log::channel('data_check')->info("Received Request: " . json_encode($request->all()));

  ///  Mail::to($request['email'])->send(new LeadAssigned($request['text'], $request['subject']));
    Mail::to('ulaskorpe@gmail.com')->send(new LeadAssigned("asdfasdf", "ffsafssfsdfsdfsdf"));

    return response()->json(['message' => 'Email sent successfully'], 200);
} catch (Exception $e) {
    return response()->json(['error' => $e->getMessage()], 500);
}
}

public function showTypes(){
    return view('show_data',['types'=>Type::orderBy('id','DESC')->get()]);
}

    public function index(){


    }



    private function splitText($text) {
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


    public function contactUs(){
        $lang = session()->get('selectedLang');
        $post = Post::where('type_id','=',35)->where('lang','=',$lang)->first();
        $parts = $this->splitSentence($post['link']);

           $local = [

            'contact_us'=>['TR'=>'İletişim','EN'=> 'Contact Us','DE'=> 'Kontaktiere Uns'],
            'get_in_touch'=>['TR'=>'Bize Ulaşın','EN'=> 'Get In Touch','DE'=> 'Kontaktieren Sie uns'],
            'header_1'=>['TR'=>$parts['part_1'],'EN'=> $parts['part_1'],'DE'=>$parts['part_1']],
            'header_2'=>['TR'=>$parts['part_2'],'EN'=> $parts['part_2'],'DE'=> $parts['part_2']],
            'send_msg'=>['TR'=>'Mesaj Gönder','EN'=> 'Send A Message','DE'=> 'Eine Nachricht schicken'],
          //  'send_paragraph'=>['TR'=>'Bize Ulaşın','EN'=> 'Get In Touch','DE'=> 'Kontaktieren Sie uns'],
            'call_us'=>['TR'=>'Bize Ulaşın','EN'=> 'Get In Touch','DE'=> 'Kontaktieren Sie uns'],
            'email_us'=>['TR'=>'Bize Yazın','EN'=> 'Email US','DE'=> 'Kontaktieren Sie uns'],
            'visit_us'=>['TR'=>'Bizi Ziyaret Edin','EN'=> 'Visit Us','DE'=> 'Kontaktieren Sie uns'],
            'name'=>['TR'=>'Ad','EN'=> 'Name','DE'=> 'Name'],
            'surname'=>['TR'=>'Soyad','EN'=> 'Surname','DE'=> 'Nachname'],
            'email_address'=>['TR'=>'Eposta Adresi','EN'=> 'E-Mail-Address','DE'=> 'E-Mail-Adresse'],
            'phone_number'=>['TR'=>'Telefon Numarası','EN'=> 'Phone Number','DE'=> 'Telefonnummer'],
            'msg'=>['TR'=>'Mesaj','EN'=> 'Message','DE'=> 'Nachricht'],
            'submit_message'=>['TR'=>'Mesaj Gönder','EN'=> 'Submit Message','DE'=> 'Nachricht senden'],
           ];



       return Inertia::render('Contact', compact(
           'local','lang','post'
       ));

    }

    public function concactSubmit(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'email' => 'required|email',
            'message'=>'required|min:10',


        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }


        $c = new Contact();
        $c->doctor_id = ($request['doctor_id']) ? $request['doctor_id']:0;
        $c->treatment_id = ($request['treatment_id']) ? $request['treatment_id']:0;
        $c->name_surname = $request['name']." ".$request['surname'];
        $c->phone = $request['phone_number'];
        $c->email = $request['email'];
        $c->message = $request['message'];
        $c->save();

        //todo :: Make send email function on observer


        $msg = ['TR'=>'Mesajınız Başarı ile iletildi' , 'EN'=>'Your Message submitted successfully','DE'=>'Ihre Nachricht wurde erfolgreich übermittelt'];


        return response()->json(['message' => $msg[session()->get('selectedLang')]], 200);
    }

    public function aboutUs(){
        $type_array = [9,10,21,22,30,31,32,33];

           $posts = Post::whereIn('type_id',$type_array)
           ->where('show_post','=',1)
           ->where('lang','=',session()->get('selectedLang'))
           ->orderBy('count')->get();


           foreach($posts as $item){
               switch ($item['type_id']) {
                case 30:
                    $gallery_spot = ['title'=>$item['title'],'second_title'=>$item['second_title'],'link'=>$item['link'],'third_title'=>$item['third_title']];
                        break;
                case 31:
                        $gallery_items[] = ['title'=>$item['title'],'image'=>$item['image'] ];
                        break;
                   case 9:
                       $about_us_spot = $item ; //['title'=>$item['title'],'second_title'=>$item['second_title'],'third_title'=>$item['third_title'],'prologue'=>$item['prologue'],'image'=>$item['image'],'second_image'=>$item['second_image'],'third_image'=>$item['third_image']];

                       break;
                   case 10:

                       $about_us_items[] =['title'=> $item['title'],'link'=>$item['link']];
                       break;

                       case 21:
                        $video_spot = ['title'=>$item['title'],'second_title'=>$item['second_title'],'link'=>$item['link']
                        ,'third_title'=>$item['third_title']];
                        break;
                    case 22:
                        $video_items[] = ['title'=>$item['title'],'image'=>$item['image'],'prologue'=>$item['prologue']];
                        break;

                        case 32:
                            $doctors_spot = ['title'=>$item['title'],'second_title'=>$item['second_title'],'link'=>$item['link']
                            ,'third_title'=>$item['third_title']];
                            break;
                        case 33:
                            $doctors[] = ['title'=>$item['title'],'image'=>$item['image'],'second_title'=>$item['second_title'],'id'=>$item['id'],'slug'=>Str::slug($item['title'])];
                            break;
               }

           }



           $text = $this->splitText($about_us_spot['content']);
          $part_1= $text[0];
           $part_2= $text[1];
           $title_head = $about_us_spot['title'];

           $local = [
            'meet' =>['EN'=>'Meet','TR'=>'Ekibimiz ile','DE'=>'Lernen Sie unser '],
            'our_team' =>['EN'=>'Our Team','TR'=>'Tanışın','DE'=>'Team kennen'],
            'our_dentists' =>['EN'=>'Our Dentists','TR'=>'Hekimlerimiz','DE'=>'Unsere Zahnärzte'],
            'detail_url' =>['TR'=>'hekimlerimiz', 'EN'=>'our-dentists', 'DE'=>'unsere-zahnarzte'],
            'doctor_detail' => ['TR'=>'/hekim-detay','EN'=> '/dentist-detail','DE'=> '/zahnarzt-detail'],

            'view_our_dentists' =>['EN'=>'View Our Dentists','TR'=>'Hekimlerimiz ile Tanışın','DE'=>'Unsere Zahnärzte ansehen'],
           ];
           $lang = session()->get('selectedLang');
         //     $randomKeys = array_rand($doctors, (count($doctors)>=4)?4:count($doctors));


         //    $doctors = array_map(fn($key) => $doctors[$key], $randomKeys);


       return Inertia::render('AboutUsPage', compact(
           'title_head','part_1','part_2','gallery_spot', 'gallery_items',
           'about_us_spot', 'about_us_items','video_spot','video_items','local','lang','doctors_spot','doctors'
       ));

    }
    public function setLanguage($lang){
            session()->put('selectedLang',$lang);
            return redirect()->back();
    }
    public function faqPage($slug=null,$selected=0){


           $posts = Post::with('children')->where('type_id','=',36)
           ->where('show_post','=',1)
           ->where('lang','=',session()->get('selectedLang'))
           ->orderBy(column: 'count')->get();


            $i=0;
           foreach($posts as $item){

                    $sub_items = [];
                    if($item['children']){
                        foreach($item['children'] as $child){
                            if($child['lang']==session()->get('selectedLang')){
                                $sub_items[] =  ['title'=>$child['title'],'count'=>$child['count'],'second_title'=>$child['second_title'],'prologue'=>$child['prologue']];
                            }
                        }
                    }

                    $parts = $this->splitSentence($item['title']);
                    $faq_cats[$i] = ['title'=>$item['title'],'count'=>$item['count'],'link'=>$item['link'],'sub_items'=>$sub_items,'id'=>$item['id']
                    ,'part_1'=>$parts['part_1'],'part_2'=>$parts['part_2'],'slug'=>Str::slug($item['title'])];
                    if($selected == 0 && $i==0){
                        $selected_faq = $faq_cats[$i];
                    }else{
                        if($selected == $item['id']){
                            $selected_faq = $faq_cats[$i];
                        }
                    }
                    $i++;


           }


           $local = [
            'url'=>['TR'=>'/sss', 'EN'=> '/faq','DE'=> '/hgf'],
            'title_head' =>['EN'=>'Frequently Asked Questions','TR'=>'Sıkça Sorulan Sorular','DE'=>'Häufig gestellte Fragen'],
            'how_can_we_help' =>['EN'=>'How Can We Help?','TR'=>'Nasıl Yardımcı Olabiliriz?','DE'=>'Wie können wir helfen?'],
            'paragraph_1' =>['EN'=>'If you need any helps,please feel free to contact us.','TR'=>'Herhangi bir yardıma ihtiyacınız olursa lütfen bizimle iletişime geçmekten çekinmeyin.'
            ,'DE'=>'Wenn Sie Hilfe benötigen, können Sie sich gerne an uns wenden.'],
           ];
           $lang = session()->get('selectedLang');



       return Inertia::render('Faq', compact(  'local','lang','faq_cats','selected_faq'));

    }


    public function blogs( $page=0,$tag_id=0){


        $type_array = [26];
        $per_page= 6;

           $posts = Post::with('children')->whereIn('type_id',$type_array)
           ->where('show_post','=',1)
           ->where('lang','=',session()->get('selectedLang'));
        if($tag_id>0){
            $tag = Post::find($tag_id);
            $posts  = $posts->whereIn('id',DB::table('blog_tag')->where('tag_id','=',$tag_id)->pluck('blog_id')->toArray());
        }else{
            $tag= null;
        }

           $posts =  $posts->orderBy('created_at','DESC')->get();

           //->skip($per_page*$page)->limit(100)->orderBy('created_at','DESC')->get();

        //  $posts = $posts //->skip($page*3)->limit(6)
        //    ->orderBy('created_at','DESC')->get();

       //    dd($posts);
        $blog_items =[];
        foreach($posts as $item){
            $blog_items[] = ['title'=>$item['title'],'prologue'=>$item['prologue'],'image'=>$item['image'],'second_title'=>$item['second_title'],'slug'=>Str::slug($item['title']),'id'=>$item['id']];
        }



           $local = [

            'title_head' =>['TR'=>'Haberler ve Güncellemeler', 'EN'=>'News and Updates', 'DE'=> 'Neuigkeiten und Updates'],
            'how_can_we_help' =>['EN'=>'How Can We Help?','TR'=>'Nasıl Yardımcı Olabiliriz?','DE'=>'Wie können wir helfen?'],
            'paragraph_1' =>['EN'=>'If you need any helps,please feel free to contact us.','TR'=>'Herhangi bir yardıma ihtiyacınız olursa lütfen bizimle iletişime geçmekten çekinmeyin.'
            ,'DE'=>'Wenn Sie Hilfe benötigen, können Sie sich gerne an uns wenden.'],
           ];
           $lang = session()->get('selectedLang');

           $title_head = $this->splitSentence($local['title_head'][$lang]);

       return Inertia::render('NewsAndUpdates', compact(  'local','lang','posts','title_head','blog_items','tag'));

    }

    public function blogDetail($slug,$id){
        $type_array = [26];

        $tags = Post::select('title','id')->whereIn('id',DB::table('blog_tag')->where('blog_id','=',$id)->pluck('tag_id')->toArray())->orderBy('title')->get();



        $blog = Post::find($id);



    //    $posts = Post::with('children')->whereIn('type_id',$type_array)
    //    ->where('show_post','=',1)
    //    ->where('lang','=',session()->get('selectedLang'));


    // $blog_items =[];
    // foreach($posts as $item){
    //     $blog_items[] = ['title'=>$item['title'],'prologue'=>$item['prologue'],'image'=>$item['image'],'second_title'=>$item['second_title'],'slug'=>Str::slug($item['title']),'id'=>$item['id']];
    // }

// dd($blog);


       $local = [

        'title_head' =>['TR'=>'Haberler ve Güncellemeler', 'EN'=>'News and Updates', 'DE'=> 'Neuigkeiten und Updates'],
        'how_can_we_help' =>['EN'=>'How Can We Help?','TR'=>'Nasıl Yardımcı Olabiliriz?','DE'=>'Wie können wir helfen?'],
        'paragraph_1' =>['EN'=>'If you need any helps,please feel free to contact us.','TR'=>'Herhangi bir yardıma ihtiyacınız olursa lütfen bizimle iletişime geçmekten çekinmeyin.'
        ,'DE'=>'Wenn Sie Hilfe benötigen, können Sie sich gerne an uns wenden.'],
       ];
       $lang = session()->get('selectedLang');

       $title_head = $this->splitSentence($local['title_head'][$lang]);

   return Inertia::render('BlogDetail', compact(  'local','lang','title_head','blog','tags'));

    }


    public function treatmentDetail($slug,$id){

    try{


        $treatment = Post::find($id);
        $lang = session()->get('selectedLang');

        $other_posts  = Post::select('title','id')->where('type_id','=',12)->where('lang','=',$lang)->where('id','<>',$id)->orderBy('count')->get();
        $others= [];
        foreach($other_posts as $item){
                $others[]= ['id'=>$item['id'],'title'=>$item['title'],'slug'=>Str::slug($item['title'])];
        }

        if($treatment['faq_id']){
            $faq_items = Post::where('parent_id','=',$treatment['faq_id'])
            ->where('lang','=',session()->get('selectedLang'))
            ->orderBy('count')->get();
        }else{
            $faq_items = [];
        }


       $local = [
        'faq_head' =>['EN'=>'Frequently Asked Questions','TR'=>'Sıkça Sorulan Sorular','DE'=>'Häufig gestellte Fragen'],

        'how_can_we_help' =>['EN'=>'How Can We Help?','TR'=>'Nasıl Yardımcı Olabiliriz?','DE'=>'Wie können wir helfen?'],
        'paragraph_1' =>['EN'=>'If you need any helps,please feel free to contact us.','TR'=>'Herhangi bir yardıma ihtiyacınız olursa lütfen bizimle iletişime geçmekten çekinmeyin.'
        ,'DE'=>'Wenn Sie Hilfe benötigen, können Sie sich gerne an uns wenden.'],
        'name'=>['TR'=>'Ad','EN'=> 'Name','DE'=> 'Name'],
        'surname'=>['TR'=>'Soyad','EN'=> 'Surname','DE'=> 'Nachname'],
        'email_address'=>['TR'=>'Eposta Adresi','EN'=> 'E-Mail-Address','DE'=> 'E-Mail-Adresse'],
        'phone_number'=>['TR'=>'Telefon Numarası','EN'=> 'Phone Number','DE'=> 'Telefonnummer'],
        'send_msg' =>['EN'=>'Send Message','TR'=>'Mesaj Gönder','DE'=>'Nachricht senden'],
        'msg'=>['TR'=>'Mesaj','EN'=> 'Message','DE'=> 'Nachricht'],
       ];

       $title_head = $this->splitSentence($treatment['title']);
       $third_one = $this->splitSentence($treatment['third_title']);
       $faq_head = $this->splitSentence($local['faq_head'][$lang]);
       $how_can_we_help = $this->splitSentence($local['how_can_we_help'][$lang]);

   return Inertia::render('TreatmentDetail', compact(  'local','lang','title_head','treatment','third_one','faq_head','faq_items','others','how_can_we_help' ));
}catch(Exception $exception){

}
    }


    public function ourDentists(){
        $type_array = [33];
        $posts = Post::whereIn('type_id',$type_array)
        ->where('show_post','=',1)
    ->where('lang','=',session()->get('selectedLang'))
        ->orderBy('count')->get();

        //Zahnarzt,Zahnärztin,Dentist,Diş Hekimi
         $array = ['zahnarzt','zahnarztin','dentist','dis_hekimi'];

        foreach($posts as $item){

                $second_title = GeneralHelper::fixName($item['second_title']);

                  if(in_array($second_title,$array)) {

                $dentists[] = ['title'=>$item['title'],
                'second_title'=>$item['second_title'],

                'id'=>$item['id'],'count'=>$item['count'],'link'=>$item['link'] ,
                'image'=>$item['image'],'prologue'=>$item['prologue'],'slug'=>Str::slug($item['title'])];
               }
        }

        $local = [

        'title_head' =>['EN'=>'Our Dentists','TR'=>'Hekimlerimiz','DE'=>'Unsere Zahnärzte'],
        'detail_url'=>['TR'=>'hekim-detay', 'EN'=>'dentist-detail','DE'=> 'zahnarzt-detail']
        ];
        $lang = session()->get('selectedLang');



    return Inertia::render('Dentists', compact( 'local','lang','dentists'));
    }

    public function dentistDetail ($slug ,$id){
        $post = Post::with('children')->find($id);

        $split_txt = $this->splitText($post['title']);

        $local = [
            'dentists_route' => ['TR'=>'/hekimlerimiz', 'EN'=>'/our-dentists', 'DE'=>'/unsere-zahnarzte'],
            'our_dentists' =>['EN'=>'Our Dentists','TR'=>'Hekimlerimiz','DE'=>'Unsere Zahnärzte'],
            'detail_url'=>['TR'=>'hekim-detay', 'EN'=>'dentist-detail','DE'=> 'zahnarzt-detail'],

            'name'=>['TR'=>'Ad','EN'=> 'Name','DE'=> 'Name'],
            'surname'=>['TR'=>'Soyad','EN'=> 'Surname','DE'=> 'Nachname'],
            'email_address'=>['TR'=>'Eposta Adresi','EN'=> 'E-Mail-Address','DE'=> 'E-Mail-Adresse'],
            'phone_number'=>['TR'=>'Telefon Numarası','EN'=> 'Phone Number','DE'=> 'Telefonnummer'],
            'send_msg' =>['EN'=>'Send Message','TR'=>'Mesaj Gönder','DE'=>'Nachricht senden'],
            'msg'=>['TR'=>'Mesaj','EN'=> 'Message','DE'=> 'Nachricht'],

        ];

        $lang = session()->get('selectedLang');
        $get_free =['TR'=>'Ücretsiz teklif alın','EN'=>'Get a free quote','DE'=>'Erhalten Sie ein kostenloses Angebot'];
        $qua_exp =['TR'=>'Nitelikler & deneyim','EN'=>'Qualifications & experience','DE'=>'Qualifikationen & Erfahrung'];
        $qua_exp = explode('&',$qua_exp[$lang]);
        $get_free = $this->splitSentence($get_free[$lang]);

        return Inertia::render('DentistDetail', compact( 'post','local','lang','split_txt','qua_exp','get_free'));
    }

    public function gallery(){
        $type_array = [31];
        $posts = Post::with('children')->whereIn('type_id',$type_array)
        ->where('show_post','=',1)
      ->where('lang','=',session()->get('selectedLang'))
        ->orderBy('count')->get();


        foreach($posts as $item){
            switch ($item['type_id']) {

            case 31:
                 $gallery_items[] = ['title'=>$item['title'],'count'=>$item['count'],'link'=>$item['link'] ,'image'=>$item['image']];;
             break;

        }
        }




        $local = [

         'title_head' =>['EN'=>'Frequently Asked Questions','TR'=>'Sıkça Sorulan Sorular','DE'=>'Häufig gestellte Fragen'],
         'how_can_we_help' =>['EN'=>'How Can We Help?','TR'=>'Nasıl Yardımcı Olabiliriz?','DE'=>'Wie können wir helfen?'],
         'paragraph_1' =>['EN'=>'If you need any helps,please feel free to contact us.','TR'=>'Herhangi bir yardıma ihtiyacınız olursa lütfen bizimle iletişime geçmekten çekinmeyin.'
         ,'DE'=>'Wenn Sie Hilfe benötigen, können Sie sich gerne an uns wenden.'],
         'gallery'=>['TR'=>'Galeri', 'EN'=>'Gallery', 'DE'=>'Galerie'],
         'media'=>['TR'=>'Medya', 'EN'=>'Media', 'DE'=>'Medien']
        ];
        $lang = session()->get('selectedLang');



    return Inertia::render('Gallery', compact( 'local','lang','gallery_items'));

    }

    private function splitSentence($sentence){

$words = explode(' ', $sentence);
$middle = ceil(count($words) / 2);

$part1 = implode(' ', array_slice($words, 0, $middle));
$part2 = implode(' ', array_slice($words, $middle));
        return ['part_1'=>$part1,'part_2'=>$part2];
    }

}
