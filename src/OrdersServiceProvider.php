<?php

declare(strict_types=1);

namespace Mortezaa97\Orders;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Mortezaa97\Orders\Models\Cart;
use Mortezaa97\Orders\Models\Order;
use Mortezaa97\Orders\Models\PayType;
use Mortezaa97\Orders\Models\SendType;
use Mortezaa97\Orders\Policies\CartPolicy;
use Mortezaa97\Orders\Policies\OrderPolicy;
use Mortezaa97\Orders\Policies\PayTypePolicy;
use Mortezaa97\Orders\Policies\SendTypePolicy;

class OrdersServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        // Load migrations
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        // Load routes
        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');

        // Register policies
        Gate::policy(Order::class, OrderPolicy::class);
        Gate::policy(Cart::class, CartPolicy::class);
        Gate::policy(SendType::class, SendTypePolicy::class);
        Gate::policy(PayType::class, PayTypePolicy::class);

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/config.php' => config_path('order.php'),
            ], 'config');

            $this->publishes([
                __DIR__ . '/../database/migrations' => database_path('migrations'),
            ], 'migrations');

            $this->publishes([
                __DIR__ . '/../database/seeders' => database_path('seeders'),
            ], 'orders-seeders');
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'orders');

        // Register the main class to use with the facade
        $this->app->singleton('orders', function () {
            return new Orders;
        });
    }
}
