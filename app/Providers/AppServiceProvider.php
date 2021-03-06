<?php

namespace App\Providers;

use App\Category;
use App\Comment;
use App\Post;
use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;
use Jenssegers\Date\Date;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        view()->composer('pages._sidebar', function($view){
            $view->with('popularPosts', Post::getPopularPosts());
            $view->with('featuredPosts', Post::where('is_featured', 1)->take(3)->get());
            $view->with('recentPosts', Post::orderBy('date', 'desc')->take(4)->get());
            $view->with('categories', Category::all());
        });

        view()->composer('admin._sidebar', function($view){
            $view->with('newCommentsCount', Comment::where('status',0)->count());
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Date::setlocale(config('app.locale'));
    }
}
