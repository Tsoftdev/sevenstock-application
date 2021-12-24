<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;
use DB;

use App\Models\User;
use App\Models\Company;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
                
        view()->composer('*', function ($view) {
            if (Auth::guard('admin')->check()){
                $adminmemos_count=DB::table('adminmemos')
                    ->where('isRead', '=', 'N')
                    ->where('adminmemos.userId',Auth::guard('admin')->user()->id)
                    ->count();
                $adminmemoes = User::all()->except(Auth::guard('admin')->user()->id);
                $companies = Company::all();
                view()->share('adminmemos_count', $adminmemos_count);
                view()->share('adminmemos', $adminmemoes);
                view()->share('companies', $companies);
            }
                
        });

        
       
    }
}
