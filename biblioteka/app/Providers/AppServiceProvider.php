<?php

namespace App\Providers;

use App\Models\BookRequest;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        Schema::defaultStringLength(191);

        View::composer('layouts.admin', function ($view) {
            $pendingRequestsCount = BookRequest::where('status', 'na čekanju')->count();

            $recentPendingRequests = BookRequest::where('status', 'na čekanju')
                ->with('book')
                ->latest()
                ->take(5)
                ->get();

            $view->with(compact('pendingRequestsCount', 'recentPendingRequests'));
        });
    }
}
