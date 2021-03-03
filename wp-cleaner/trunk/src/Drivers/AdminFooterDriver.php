<?php

declare(strict_types=1);

namespace Pollen\WpConfig\Drivers;

class AdminFooterDriver extends AbstractWpConfigDriver
{
    /**
     * @inheritDoc
     */
    public function boot(): void
    {
        if ($footer_text = $this->wpConfig()->config('admin_footer_text', '')) {
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