<?php

namespace App\Providers;

use App\Models\Document;
use App\Models\Email;
use App\Models\Personnel;
use App\Models\Product;
use App\Models\Project;
use App\Models\Quote;
use App\Models\Solution;
use App\Models\User;
use App\Observers\DocumentObserver;
use App\Observers\EmailObserver;
use App\Observers\PersonnelObserver;
use App\Observers\ProductObserver;
use App\Observers\ProjectObserver;
use App\Observers\QuoteObserver;
use App\Observers\SolutionObserver;
use App\Observers\UserObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * The model observers for your application.
     *
     * @var array
     */
    protected $observers = [
        Project::class => [ProjectObserver::class],
        Solution::class => [SolutionObserver::class],
        Quote::class => [QuoteObserver::class],
        Product::class => [ProductObserver::class],
        Document::class => [DocumentObserver::class],
        Email::class => [EmailObserver::class],
        Personnel::class => [PersonnelObserver::class],
        User::class => [UserObserver::class],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
