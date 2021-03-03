<?php

declare(strict_types=1);

namespace Pollen\WpCleaner\Drivers;

class DNSPrefetchDriver extends AbstractWpCleanerDriver
{
    /**
     * @inheritDoc
     */
    public function boot(): void
    {
        if ($this->wpCleaner()->config('disable_dns_prefetch') === true) {
            add_action(
                'wp',
                function () {
                    remove_action('wp_head', 'wp_resource_hints', 2);
                }
            );
        }
    }
}