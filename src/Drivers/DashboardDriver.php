<?php

declare(strict_types=1);

namespace Pollen\WpCleaner\Drivers;

use Pollen\WpCleaner\AbstractWpCleanerDriver;

class DashboardDriver extends AbstractWpCleanerDriver
{
    /**
     * @inheritDoc
     */
    public function boot(): void
    {
        if ($metaboxes = $this->wpCleaner()->config('remove_dashboard_meta_box', [])) {
            add_action(
                'admin_init',
                function () use ($metaboxes) {
                    foreach ($metaboxes as $metabox => $context) {
                        if (is_numeric($metabox)) {
                            remove_meta_box('dashboard_' . $context, 'dashboard', false);
                        } elseif (is_string($metabox)) {
                            remove_meta_box('dashboard_' . $metabox, 'dashboard', $context);
                        }
                    }
                }
            );
        }

        if ($panels = $this->wpCleaner()->config('remove_dashboard_panel', [])) {
            add_action(
                'admin_init',
                function () use ($panels) {
                    foreach ($panels as $panel) {
                        remove_action("{$panel}_panel", "wp_{$panel}_panel");
                    }
                }
            );
        }
    }
}