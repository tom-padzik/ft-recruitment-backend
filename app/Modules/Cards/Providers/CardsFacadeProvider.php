<?php

declare(strict_types=1);

namespace App\Modules\Cards\Providers;

use App\Modules\Cards\Api\Contracts\CardsFacadeInterface;
use App\Modules\Cards\Application\CardsFacade;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class CardsFacadeProvider extends ServiceProvider implements DeferrableProvider
{
    public function register(): void
    {
        $this->app->singleton(
            CardsFacadeInterface::class,
            CardsFacade::class,
        );
    }

    public function provides(): array
    {
        return [
            CardsFacadeInterface::class,
        ];
    }
}