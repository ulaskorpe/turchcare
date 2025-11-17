<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Helpers\GeneralHelper;
use App\Models\Comment;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;
use App\Traits\HttpResponses;
use App\Models\User;
use App\Models\Type;

use Exception;
class AdminController extends Controller
{

  use HttpResponses;

    public function profile(){
        $type = Type::find(3);
      return view("admin_panel.profile",['user'=>Auth::user(),'type'=>Type::find(1),'type'=>$type ]);
    }


    public function messages ( ){
        $type = Type::find(3);

        return view("admin_panel.messages",['type'=>$type
        ,'posts'=>Contact::where('id','>',0)->orderBy('id','desc')->get()
         ]);
    }

    public function comments ( ){
        $type = Type::find(13);

        return view("admin_panel.comments",['type'=>$type
        ,'posts'=>Comment::with('blog')->where('id','>',0)->orderBy('id','desc')->get()
         ]);
    }

    public function contactPost(Request $request){

        //dd($request->all());
        $c = Contact::find($request['id']);
        $c->reply_subject = $request['reply_subject'];
        $c->reply_text = $request['reply_text'];
        $c->save();
       // Log::channel('data_check')->info($c['email']);
           //return   Auth::guard('admin')->check();
          return  $this->success([''],'mesajınız '.$c['email'].' adresine gönderildi' ,200);
      }


      public function messageDelete($id){

        $c = Contact::find($id);
        $c->delete();
        return redirect('/admin-panel/messages/');

    }

    public function commentConfirm($id,$confirm){

        $c = Comment::find($id);
        $c->show_comment= $confirm;
        $c->save();
        return redirect('/admin-panel/comments/');

    }
    public function commentDelete($id){

        $c = Comment::find($id);
        $c->delete();
        return redirect('/admin-panel/comments/');

    }
    public function messageDetail ( $id ){
        $contact = Contact::find($id);
       $contact->update(['is_read'=> 1]);

        return view("admin_panel.message_detail",['contact'=>$contact,'type'=> Type::find(3)]);
    }

    private $allowed_array = ['jpg', 'jpeg','png'];

    public function check_old_pw($old_pw){
        // $user = Auth::user();
        // $user->password=Hash::make('123123');
        // $user->save();
        $user = User::where('admin_code','=',Session::get('admin_code'))->first();
        if(!Hash::check( $old_pw, $user['password'])){
            return response()->json('eski şifrenizi hatalı girdiniz');
        }

        return response()->json("ok");
    }

    public function check_email($email){
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

            $ch = User::where('email','=',$email)->where('id','<>',Auth::id())->first();
            if($ch){
                return response()->json('bu email adresi ile başka kullanıcı kayıtlı');
            }
        } else {
           return response()->json("geçersiz email adresi");
        }
        return response()->json("ok");
    }

    public function check_phone($phone){


          $ch = User::where('phone','=',$phone)->where('id','<>',Auth::id())->first();
          if($ch){
              return response()->json('bu email adresi ile başka kullanıcı kayıtlı');
          }

      return response()->json("ok");
  }


    public function profile_post(Request $request){


        try{
            $user = User::where('admin_code','=',Session::get('admin_code'))->first();

            $user->email= $request['email'];
            $user->name= $request['name'];
            $user->phone= $request['phone'];

         if(!empty($request->hasFile('avatar'))){
            $file = $request->file('avatar');


           $ext =  findExtension($file->getClientOriginalName());

            if (in_array($ext, $this->allowed_array)) {

                if (!empty($file)) {
                    $path = public_path("files/users/");

                    if(!empty($user['image'])){
                      @unlink($path.$user['image']);
                      @unlink($path."200".$user['image']);
                    }


                    $filename = fixName($request['name']) . "_" . date('YmdHis') . "." .$ext;
                    $file->move($path, $filename);
                    $user->image = $filename;
                    $path = public_path("files/users/"   . $filename);
                   $resizedImage = Image::make($path)->resize(200, null, function ($constraint) {
                       $constraint->aspectRatio();
                   });
                     $resizedImage->save(public_path("files/users/200".$filename));
                   }

            }

        }

            $user->save();

            return  $this->success([''],"Bilgileriniz güncellendi" ,200);
         }catch (Exception $e){
            // return response()->json(['error' => $e->getMessage()], 500);
             return  $this->error([''], $e->getMessage() ,500);
         }




    }

    public function password_post(Request $request){
        $user = User::find(Auth::id());

        $user->password= Hash::make($request['password']);

        $user->save();

       return  $this->success([''],"Şifreniz güncellendi" ,200);
    }
}
