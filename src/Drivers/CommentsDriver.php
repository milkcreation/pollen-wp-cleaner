<?php

declare(strict_types=1);

namespace Pollen\WpCleaner\Drivers;

use Pollen\WpCleaner\AbstractWpCleanerDriver;

class CommentsDriver extends AbstractWpCleanerDriver
{
    /**
     * @inheritDoc
     */
    public function boot(): void
    {
        if ($this->wpCleaner()->config('disable_comment') === true) {
            add_action(
                'admin_menu',
                function () {
                    remove_menu_page('edit-comments.php');
                    remove_submenu_page('options-general.php', 'options-discussion.php');
                }
            );

            add_action(
                'init',
                function () {
                    remove_post_type_support('post', 'comments');
                    remove_post_type_support('page', 'comments');
                    update_option('default_comment_status', 0);
                }
            );

            add_action(
                'wp_before_admin_bar_render',
                function () {
                    global $wp_admin_bar;

                    $wp_admin_bar->remove_node('comments');

                    if (is_multisite()) {
                        foreach (get_sites() as $site) {
                            $wp_admin_bar->remove_menu('blog-' . $site->blog_id . '-c');
                        }
                    }
                }
            );

            add_action(
                'wp_widgets_init',
                function () {
                    unregister_widget('WP_Widget_Recent_Comments');
                }
            );
        }
    }
}