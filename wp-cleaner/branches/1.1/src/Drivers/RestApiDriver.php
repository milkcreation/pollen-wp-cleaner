<?php

declare(strict_types=1);

namespace Pollen\WpCleaner\Drivers;

use Pollen\WpCleaner\AbstractWpCleanerDriver;

class RestApiDriver extends AbstractWpCleanerDriver
{
    /**
     * @inheritDoc
     */
    public function boot(): void
    {
        if ($this->wpCleaner()->config('disable_rest_api')) {
            add_action(
                'init',
                function () {
                    // Disable REST API link tag
                    remove_action('wp_head', 'rest_output_link_wp_head');

                    // Disable oEmbed Discovery Links
                    remove_action('wp_head', 'wp_oembed_add_discovery_links');

                    // Disable REST API link in HTTP headers
                    remove_action('template_redirect', 'rest_output_link_header', 11);
                }
            );
        }
    }
}