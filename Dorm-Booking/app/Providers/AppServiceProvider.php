<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\AnnouncementModel;
use App\Models\RoomModel;

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
        View::composer(['home.mainpage', 'auth.login'], function ($view) {
            $AnnouncementList = AnnouncementModel::orderBy('updated_at', 'desc')->get();
            $view->with('AnnouncementList', $AnnouncementList);
        });
        View::composer(['home.mainpage', 'auth.login'], function ($view) {
            $RoomList = RoomModel::orderBy('id', 'desc')->get();
            $view->with('RoomList', $RoomList);
        });
    }
}
