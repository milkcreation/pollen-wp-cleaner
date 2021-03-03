<?php

declare(strict_types=1);

namespace Pollen\WpCleaner\Drivers;

class EmojiDriver extends AbstractWpCleanerDriver
{
    /**
     * @inheritDoc
     */
    public function boot(): void
    {
        if ($this->wpCleaner()->config('disable_emoji') === true) {
            add_filter('emoji_svg_url', '__return_false');

            add_action(
                'init',
                function () {
                    remove_action('wp_head', 'print_emoji_detection_script', 7);
                    remove_action('admin_print_scripts', 'print_emoji_detection_script');
                    remove_action('wp_print_styles', 'print_emoji_styles');
                    remove_action('admin_print_styles', 'print_emoji_styles');
                    remove_filter('the_content_feed', 'wp_staticize_emoji');
                    remove_filter('comment_text_rss', 'wp_staticize_emoji');
                    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
                }
            );

            add_filter(
                'tiny_mce_plugins',
                function ($plugins) {
                    return is_array($plugins) ? array_diff($plugins, ['wpemoji']) : [];
                }
            );
        }
    }
}