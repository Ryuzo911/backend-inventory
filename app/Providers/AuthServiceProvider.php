<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Transaction;
use App\Policies\CategoryPolicy;
use App\Policies\ProductPolicy;
use App\Policies\TransactionPolicy;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{

    protected $policies = [
        Category::class => CategoryPolicy::class,
        Product::class => ProductPolicy::class,
        Transaction::class => TransactionPolicy::class,
    ];

    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        
    }
}
