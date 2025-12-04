<?php

namespace App\Providers;

use App\Models\Booking;
use App\Models\Vehicle;
use App\Observers\BookingObserver;
use App\Observers\VehicleObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
{
    // Activation des caméras de surveillance
    Booking::observe(BookingObserver::class);
    Vehicle::observe(VehicleObserver::class);
}
}
