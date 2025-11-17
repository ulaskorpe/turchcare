<?php

namespace App\Observers;
use App\Mail\ContactMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Models\Contact;
class ContactObserver
{
   public function created(Contact $contact){
  //  Log::channel('data_check')->info($contact['message']);

        $text = $contact['name_surname']."<br>";
        $text .= $contact['phone']." , ".$contact['email']."<br>";
        $text .= "<p>". $contact['message'] ."</p><br>";
        if($contact["treatment_id"] >0){
            $text .= "Tedavi :".$contact->treatment()->first()->title;
        }
        $text .= "<br>".$contact['used_form'];

        Mail::to('info@eyeglow.com')->send(new ContactMail($text,$contact['name_surname'] .' ziyaretçiden mesaj '.date('d.m.Y H:i'))  );


   }


   public function updated(Contact $contact){
    if (!$contact->isDirty('is_read')) {
    Mail::to($contact['email'])->send(new ContactMail($contact['reply_text'],$contact['reply_subject']  ));
    }
   }
}

