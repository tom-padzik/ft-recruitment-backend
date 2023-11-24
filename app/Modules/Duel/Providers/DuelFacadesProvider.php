<?php

declare(strict_types=1);

namespace App\Modules\Duel\Providers;

use App\Modules\Duel\Api\Contracts\DuelFacadeInterface;
use App\Modules\Duel\Api\Contracts\DuelUserFacadeInterface;
use App\Modules\Duel\Application\DuelFacade;
use App\Modules\Duel\Application\DuelUserFacade;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

use function array_keys;

class DuelFacadesProvider extends ServiceProvider implements DeferrableProvider
{
    private const SINGLETONS
        = [
            DuelFacadeInterface::class => DuelFacade::class,
            DuelUserFacadeInterface::class => DuelUserFacade::class,
        ];

    public function register(): void
    {
        foreach (self::SINGLETONS as $abstract => $concrete) {
            $this->app->singleton($abstract, $concrete);
        }
    }

    public function provides(): array
    {
        return array_keys(self::SINGLETONS);
    }
}

{
}