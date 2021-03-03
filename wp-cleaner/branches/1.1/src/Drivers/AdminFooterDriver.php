<?php

declare(strict_types=1);

namespace Pollen\WpCleaner\Drivers;

class AdminFooterDriver extends AbstractWpCleanerDriver
{
    /**
     * @inheritDoc
     */
    public function boot(): void
    {
        if ($footer_text = $this->wpCleaner()->config('admin_footer_text', '')) {
            add_filter(
                'admin_footer_text',
                function (string $text = '') use ($footer_text) {
                    return $footer_text;
                },
                999999
            );
        }
    }
}