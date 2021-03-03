<?php declare(strict_types=1);

namespace Pollen\WpConfig\Drivers;

/**
 * @mixin \Pollen\WpConfig\WpConfigAwareTrait
 */
interface WpConfigDriverInterface
{
    /**
     * Chargement.
     *
     * @return void
     */
    public function boot(): void;
}