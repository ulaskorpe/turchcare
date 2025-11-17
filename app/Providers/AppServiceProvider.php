<?php

namespace App\Providers;

use App\Models\Contact;
use App\Models\Post;
use App\Models\Type;
use App\Observers\ContactObserver;
use App\Observers\PostObserver;
use App\Observers\TypeObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\App;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
       Type::observe(TypeObserver::class);
       Post::observe(PostObserver::class);
       Contact::observe(ContactObserver::class);

       View::share('currentLocale', App::getLocale());
    }
}
