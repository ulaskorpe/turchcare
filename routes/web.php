<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\HomeController;



Route::get('/syslog/{key?}',[HomeController::class,'sysLog'])->name('syslog-user');

Route::post("/contact-post", [ContactController::class,"contactPost"])->name("contact-post");
Route::post("/comment-post", [ContactController::class,"commentPost"])->name("comment-post");
Route::post("/newsletter-post", [ContactController::class,"newsletterPost"])->name("newsletter-post");

Route::get('/send-email',[FrontController::class,'sendGet'])->name('send-email-get');

Route::get('/set-language/{lang}',[FrontController::class, 'setLanguage'])->name('set-language');
Route::get('/blogs-get/{keyword?}/{page?}/{order?}/{per_page?}',[FrontController::class, 'blogsGet'])->name('blogs-get');

Route::group([ 'middleware'=>['site_data']],function (){

Route::get('/',[FrontController::class, 'home'])->name('home');
//Route::get('/under-construction',[FrontController::class, 'home'])->name('home');
//Route::get('/test',[FrontController::class, 'test'])->name('home');
$routes = ['/hakkimda', '/about-me'];
foreach ($routes as $route) {
    Route::get($route, [FrontController::class, 'aboutUs'])->name('contact-us-'.$route);
}


$routes = ['/blogs', '/bloglar'];

foreach ($routes as $route) {
    Route::get($route.'/{page?}', [FrontController::class, 'blogs'])->name('blogs-'.$route);
}


$routes = ['/blog-detay', '/blog-detail'];

foreach ($routes as $route) {
    Route::get($route.'/{slug}/{id}', [FrontController::class, 'blogDetail'])->name('blog_detail-'.$route);
}
$routes = ['/videolar', '/videos'];

foreach ($routes as $route) {
    Route::get($route.'/{page?}', [FrontController::class, 'videos'])->name('videos-'.$route);
}

$routes = ['/galleries', '/galeriler'];

foreach ($routes as $route) {
    Route::get($route.'/{page?}', [FrontController::class, 'galleries'])->name('shp-');
}


$routes = ['/galeri-detay', '/gallery-detail'];

foreach ($routes as $route) {
    Route::get($route."/{slug}/{id}", [FrontController::class, 'gallery_detail'])->name('gallery_detail-'.$route);
}


$routes = ['/bana-ulasin', '/contact-me', '/kontaktiere-uns'];

foreach ($routes as $route) {
    Route::get($route."/{subject?}", [FrontController::class, 'contactUs'])->name('contact-us-'.$route);
}



Route::get('/show-types',[HomeController::class, 'showTypes'])->name('show-types');


});

require __DIR__.'/admin_panel.php';
