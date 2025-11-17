<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;

Route::get('/send-email',[HomeController::class,'sendGet'])->name('send-email-get');

Route::get('/set-language/{lang}',[HomeController::class, 'setLanguage'])->name('set-language');

Route::group([ 'middleware'=>['site_data']],function (){

Route::get('/',[HomeController::class, 'index'])->name('index');
$routes = ['/hakkimizda', '/about-us', '/uber-uns'];

foreach ($routes as $route) {
    Route::get($route, [HomeController::class, 'aboutUs'])->name('aboutus');
}


$routes = ['/iletisim', '/contact-us', '/kontaktiere-uns'];

foreach ($routes as $route) {
    Route::get($route, [HomeController::class, 'contactUs'])->name('aboutus');
}


$routes = ['/sss', '/faq', '/hgf'];

foreach ($routes as $route) {
    Route::get($route."/{slug?}/{selected?}", [HomeController::class, 'faqPage'])->name('faq-page');
}
$routes = ['/galeri', '/gallery', '/galerie'];

foreach ($routes as $route) {
    Route::get($route, [HomeController::class, 'gallery'])->name('gallery-page');
}


$routes = ['/hekimlerimiz', '/our-dentists', '/unsere-zahnarzte'];

foreach ($routes as $route) {
    Route::get($route, [HomeController::class, 'ourDentists'])->name('dentists-page');
}


$routes = ['/haberler-ve-guncellemeler', '/news-and-updates', '/neuigkeiten-und-updates'];

foreach ($routes as $route) {
    Route::get($route."/{page?}/{tag_id?}", [HomeController::class, 'blogs'])->name('blogs-page');
}


foreach ($routes as $route) {
    Route::get($route."/{slug}/detail/{id}", [HomeController::class, 'blogDetail'])->name('blogs-detail');
}

$routes  = ['/hekim-detay', '/dentist-detail', '/zahnarzt-detail'];

foreach ($routes as $route) {
    Route::get($route.'/{slug?}/{id}', [HomeController::class, 'dentistDetail'])->name('dentist-detail');
}

$routes  = ['/tedaviler', '/treatments', '/behandlungen'];

foreach ($routes as $route) {
    Route::get($route.'/{slug?}/{id}', [HomeController::class, 'treatmentDetail'])->name('treatment-detail');
}

Route::post('/contact-submit',[HomeController::class, 'concactSubmit'])->name('contact-submit');
Route::get('/show-types',[HomeController::class, 'showTypes'])->name('show-types');
//Route::get('/about',[HomeController::class, 'about'])->name('about');
// Route::inertia('/about','About/index');
//Route::resource('/posts',PostController::class)->except('index');

});
Route::group(['prefix'=>'admin-panel' ],function (){
    Route::get('/remember-me',[AuthController::class, 'remember_me'])->name('remember-me');
    Route::post('/login-post',[AuthController::class,'login_post'])->name('admin-login-post');
    Route::get('/admin-login',[AuthController::class,'login'])->name('admin-login');


    Route::group([ 'middleware'=>['auth','checkAdmin']],function (){

        Route::get('/notifications',[AdminController::class, 'notifications'])->name('notifications');
        Route::get('/admin-settings',[AdminController::class, 'admin_settings'])->name('admin-settings');
        Route::get('/check-email/{email}',[AdminController::class, 'check_email'])->name('check-email');
        Route::get('/check-phone/{phone}',[AdminController::class, 'check_phone'])->name('check-phone');
        Route::get('/check-old-pw/{pw}',[AdminController::class, 'check_old_pw'])->name('check-old-pw');
        Route::group(['prefix'=>'content' ],function (){
            Route::get('/list/{type}/{lang?}/{parent_id?}',[ContentController::class,'list'])->name('content-list');
            Route::get('/create/{type}/{lang?}/{parent_id?}',[ContentController::class,'create'])->name('content-create');
            Route::post('/create',[ContentController::class,'createPost'])->name('content-create-post');

            Route::get('/update/{id}',[ContentController::class,'update'])->name('content-update');
            Route::post('/update',[ContentController::class,'updatePost'])->name('content-update-post');

            Route::get('/delete/{id}',[ContentController::class,'deletePost'])->name('content-delete');
            Route::post('/copy_others',[ContentController::class,'copyOthers'])->name('content-copy-others');
            Route::get('/change_lang/{id}/{lang}',[ContentController::class,'changeLang'])->name('change-lang');

        });

        Route::get('/profile',[AdminController::class, 'profile'])->name('profile');
        Route::get('/settings',[AdminController::class, 'settings'])->name('settings');
        Route::post('/profile',[AdminController::class, 'profile_post'])->name('profile-post');
        Route::post('/settings',[AdminController::class, 'settings_post'])->name('settings-post');
        Route::post('/password-post',[AdminController::class, 'password_post'])->name('password-post');
        Route::get('/',[DashboardController::class, 'index'])->name('dashboard');
     //   Route::get('/test-1',[DashboardController::class, 'test1'])->name('test1');
        Route::post('/logout',[AuthController::class,'logout'])->name('logout');


//'lang','type_id','count','title','second_title','prologue','content','link','image','second_image'
    });
});

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     //return redirect('/admin-login');
// });
