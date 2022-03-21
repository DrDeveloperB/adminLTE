<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

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
        DB::listen(function ($query) {
            // || config('app.env') === 'local'
            if (env('LOG_QUERY', false) === true) {
                $sql = $query->sql;
                $bindings = $query->bindings;
                $queries = array(array('query' => $sql, 'bindings' => $bindings));
                ddd(getSqlWithBindings($queries));
//                var_dump($query->sql);
            }
//            Log::info(
//                $query->sql,
//                $query->bindings,
//                $query->time
//            );
//             $sql = $query->sql;
            // $query->bindings;
            // $query->time;
        });

        Paginator::defaultView('pagination-links');
        Paginator::defaultSimpleView('pagination-links');
    }
}
