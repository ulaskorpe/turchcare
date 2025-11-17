<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Contact;
use App\Models\NewsLetter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Traits\HttpResponses;
class ContactController extends Controller
{

    use HttpResponses;
    public function contactPost(Request $request){

        //dd($request->all());
        $c = new Contact();
        $c->used_form = $request['used_form'];
        if(!empty($request['name_1'])){



        $c->name_surname = $request['name_1']." ".$request['surname_1'] ;
        $c->email = $request['email_1'];
        $c->phone = $request['phone_1'] ?? 'n/a';
        $c->treatment_id = $request['treatment_id'] ??0;
        $c->message = $request['message_1'];
        }else{

            $c->name_surname = $request['name']." ".$request['surname'] ;
            $c->email = $request['email'];
            $c->phone = $request['phone'] ?? 'n/a';
            $c->message = $request['message'];
        }


        $c->is_read = 0;
        $c->save();
       // Log::channel('data_check')->info($c['email']);
           //return   Auth::guard('admin')->check();
          return  $this->success([''],__('front.message_sent') ,200);
      }
      public function commentPost (Request $request){

        //dd($request->all());
        $c = new Comment();
        $c->blog_id = $request['blog_id'];
        $c->ip_address = $request['ip_address'];


            $c->name = $request['name'] ;
            $c->email = $request['email'];
            $c->phone = $request['phone'] ?? 'n/a';
            $c->message = $request['message'];



        $c->show_comment = 0;
        $c->save();
       // Log::channel('data_check')->info($c['email']);
           //return   Auth::guard('admin')->check();
          return  $this->success([''],__('front.comment_sent') ,200);
      }

      public function newsletterPost(Request $request){

        $c = new NewsLetter();

        $c->email = $request['email_news_letter'];

        $c->is_active = 1;
        $c->save();

           //return   Auth::guard('admin')->check();
          return  $this->success([''],__('front.newsletter_added') ,200);
      }

}
