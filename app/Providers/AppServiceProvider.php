<?php

namespace App\Providers;

use App\Models\Boutique;
use App\Models\Category;
use App\Models\Enquiry;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\User;
use App\Policies\BoutiquePolicy;
use App\Policies\EnquiryPolicy;
use App\Policies\ProductImagePolicy;
use App\Policies\ProductPolicy;
use App\Policies\ProductVariantPolicy;
use App\Policies\UserPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Gate::policy(User::class, UserPolicy::class);
        Gate::policy(Boutique::class, BoutiquePolicy::class);
        Gate::policy(Product::class, ProductPolicy::class);
        Gate::policy(ProductVariant::class, ProductVariantPolicy::class);
        Gate::policy(ProductImage::class, ProductImagePolicy::class);
        Gate::policy(Enquiry::class, EnquiryPolicy::class);

        View::composer('components.header', function ($view) {
            $view->with('navCategories', Category::orderBy('name')->get());
        });
    }
}
