<?php

declare(strict_types=1);

namespace Pollen\WpConfig\Drivers;

use WP_Admin_Bar;

class AdminBarDriver extends AbstractWpConfigDriver
{
    /**
     * @inheritDoc
     */
    public function boot(): void
    {
        if ($nodes = $this->wpConfig()->config('remove_admin_bar_menu', [])) {
            add_action(
                'wp_before_admin_bar_render',
                function () use ($nodes) {
                    global $wp_admin_bar;

                    foreach ($nodes as $admin_bar_node) {
                        $wp_admin_bar->remove_node($admin_bar_node);
                    }
                }
            );
        }

        if ($logo = $this->wpConfig()->config('admin_bar_menu_logo', [])) {
            add_action(
                'admin_bar_menu',
                function (WP_Admin_Bar $wp_admin_bar) use ($logo) {
                    $wp_admin_bar->remove_menu('wp-logo');

                    foreach ($logo as $node) {
                        if (!empty($node['group'])) {
                            $wp_admin_bar->add_group($node);
                        } else {
                            $wp_admin_bar->add_menu($node);
                        }
                    }
                },
                11
            );
        }
    }
}