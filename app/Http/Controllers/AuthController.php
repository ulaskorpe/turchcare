<?php

namespace App\Http\Controllers;

// use App\Http\Requests\LoginUserRequest;
// use App\Http\Requests\StoreUserRequest;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\User;


class AuthController extends Controller
{
    use HttpResponses;

    public function __construct(){

    }
    public function remember_me(){
        return view('admin.call_me');
    }


    private function attachPermissions(){
        $user = User::find(Auth::id()) ;
        foreach( $user->permissions as $p){

        }
    }

    public function login(){

  //Session::put('admin_code',"4234423");
//   Session::put('key', 'value');

//   // Retrieve data from the session
//   $value = Session::get('key');

//   // Flash data for the next request
//   Session::flash('status', 'Session data stored!');

   ///  dd(Session::all());

// To set and retrieve a session value
// Session::put('ke33y', 'valu3333e');
// dd(Session::get('ke33y'));
// echo "xxxx".Session::get('admin_code');
        // return Auth::guard('admin') ;
        // Cookie::queue('remember_me', '',0);
        // //  Auth::user()->currentAccessToken()->delete();
        //  Auth::guard('admin')->logout();
           // return  Auth::guard('admin')->user() ;

        //  Session::forget('admin_code');
        if( Cookie::get('remember_me')){

            $admin = User::where('remember_token', Cookie::get('remember_me'))->first();

            if ($admin) {
           Auth::login($admin);

                Session::put('admin_code',$admin['admin_code']);
                return redirect('admin-panel');
            }

        }

        //if(Auth::guard('admin')->check()){
        if(!empty(Session::get('admin_code'))){
              return redirect('/admin-panel');
        }


        return view('admin_panel.login');
    }



    public function login_post(Request $request){
      $admin = User::where('admin_code','=',(integer)$request->admin_code)->first();


        if(!Auth::attempt(['admin_code' =>(integer)$request->admin_code, 'password' =>(string)$request->password])){

            return $this->error('','no such admin',200);
        }

        if($admin['status']==0){
              Auth::logout();
              return $this->error('','no such admin',200);
              //return $this->error(data: [], '',200);
          }
      //  Auth::guard('admin')->login($admin);




        Session::put('admin_code',value: $admin['admin_code']);

        if(empty($request['remember_me'])) {
                $rememberToken = Str::random(60); // Generate a random token
                  Cookie::queue('remember_me', $rememberToken, 60*24*30);
                $admin->remember_token = $rememberToken;
                $admin->save();
               // $remember=$request['remember_me'];
            }

         //return   Auth::guard('admin')->check();
        return  $this->success(['admin'=>$admin],"Giriş yapıldı" ,200);
    }

    public function logout(Request $request){
        Cookie::queue('remember_me', '',0);
       //  Auth::user()->currentAccessToken()->delete();
        Auth::logout();


        Session::forget('admin_code');
       //  return $this->success('','logged out',200);
       return redirect(route('admin-login'));
    }
}
