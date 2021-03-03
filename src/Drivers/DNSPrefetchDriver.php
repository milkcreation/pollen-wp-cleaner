<?php

declare(strict_types=1);

namespace Pollen\WpConfig\Drivers;

class DNSPrefetchDriver extends AbstractWpConfigDriver
{
    /**
     * @inheritDoc
     */
    public function boot(): void
    {
        if ($this->wpConfig()->config('disable_dns_prefetch') === true) {
            add_action(
                'wp',
                function () {
                    remove_action('wp_head', 'wp_resource_hints', 2);
                }
            );
        }
    }
}