<?php

declare(strict_types=1);

namespace Pollen\WpCleaner\Drivers;

use Pollen\WpCleaner\WpCleanerProxyInterface;

interface WpCleanerDriverInterface extends WpCleanerProxyInterface
{
    /**
     * Chargement.
     *
     * @return void
     */
    public function boot(): void;
}