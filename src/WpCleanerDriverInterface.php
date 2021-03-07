<?php

declare(strict_types=1);

namespace Pollen\WpCleaner;

interface WpCleanerDriverInterface extends WpCleanerProxyInterface
{
    /**
     * Chargement.
     *
     * @return void
     */
    public function boot(): void;
}