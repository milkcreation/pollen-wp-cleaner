<?php

declare(strict_types=1);

namespace Pollen\WpConfig\Drivers;

class MetaTagDriver extends AbstractWpConfigDriver
{
    /**
     * @inheritDoc
     */
    public function boot(): void
    {
        if ($this->wpConfig()->config('disable_meta_tag') === true) {
            add_action(
                'init',
                function () {
                    remove_action('wp_head', 'rsd_link');
                    remove_action('wp_head', 'wlwmanifest_link');
                    remove_action('wp_head', 'wp_generator');
                    remove_action('wp_head', 'wp_shortlink_wp_head');
                    remove_action('wp_head', 'wp_dlmp_l10n_style');
                    remove_action('wp_head', 'wp_shortlink_wp_head');
                }
            );
        }
    }
}