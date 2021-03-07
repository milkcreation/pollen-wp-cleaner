<?php

declare(strict_types=1);

namespace Pollen\WpCleaner\Drivers;

use Pollen\WpCleaner\AbstractWpCleanerDriver;
use Pollen\Support\Proxy\HttpRequestProxy;
use WP_Post_Type;

class PostTypeDriver extends AbstractWpCleanerDriver
{
    use HttpRequestProxy;

    /**
     * @inheritDoc
     */
    public function boot(): void
    {
        add_action(
            'init',
            function () {
                $configKeys = $this->wpCleaner()->config()->keys();

                foreach ($configKeys as $key) {
                    if (!preg_match('/^remove_support_(.*)/', $key, $match)) {
                        continue;
                    }

                    $post_type = $match[1];

                    if (!post_type_exists($post_type)) {
                        continue;
                    }

                    foreach ($this->wpCleaner()->config($key, []) as $support) {
                        remove_post_type_support($post_type, $support);
                    }
                }
            },
            999999
        );

        add_action(
            'add_meta_boxes',
            function () {
                $configKeys = $this->wpCleaner()->config()->keys();

                foreach ($configKeys as $key) {
                    if (!preg_match('/^remove_meta_box_(.*)/', $key, $match)) {
                        continue;
                    }

                    $post_type = $match[1];

                    if (!post_type_exists($post_type)) {
                        continue;
                    }

                    foreach ($this->wpCleaner()->config($key, []) as $metabox => $context) {
                        if (is_numeric($metabox)) {
                            $metabox = $context;
                            $context = false;
                        }

                        remove_meta_box($metabox, $post_type, $context);

                        // Hack Wordpress : Maintient du support de la modification du permalien
                        if ($metabox === 'slugdiv') {
                            add_action(
                                'edit_form_before_permalink',
                                function ($post) use ($post_type) {
                                    if ($post->post_type !== $post_type) {
                                        return;
                                    }

                                    $editable_slug = apply_filters('editable_slug', $post->post_name, $post);
                                    echo "<input name=\"post_name\" type=\"hidden\" size=\"13\" id=\"post_name\" value=\"" .
                                        esc_attr($editable_slug) . "\" autocomplete=\"off\" />";
                                }
                            );
                        }
                    }
                }
            },
            999999
        );

        if ($this->wpCleaner()->config('disable_post') === true) {
            add_action(
                'admin_init',
                function () {
                    remove_meta_box('dashboard_quick_press', 'dashboard', 'normal');
                }
            );

            add_action(
                'admin_menu',
                function () {
                    remove_menu_page('edit.php');
                }
            );

            add_filter(
                'nav_menu_meta_box_object',
                function (WP_Post_Type $post_type) {
                    return $post_type->name === 'post' ? false : $post_type;
                }
            );

            add_action(
                'wp_before_admin_bar_render',
                function () {
                    global $wp_admin_bar;

                    $wp_admin_bar->remove_node('new-post');
                }
            );

            /* checks the request and redirects to the dashboard */
            add_action(
                'init',
                function () {
                    global $pagenow, $wp_post_types;

                    if (isset($wp_post_types['post'])) {
                        $wp_post_types['post']->exclude_from_search = true;
                    }

                    switch ($pagenow) {
                        case 'edit.php':
                            if ($this->httpRequest()->query->get('post_type') === 'post') {
                                wp_safe_redirect(get_admin_url(), 301);
                                exit;
                            }
                            break;
                        case 'edit-tags.php':
                        case 'post-new.php':
                            if (
                                !array_key_exists('post_type', $this->httpRequest()->query->all()) &&
                                !array_key_exists('taxonomy', $this->httpRequest()->query->all()) &&
                                !$this->httpRequest()->request->all()
                            ) {
                                wp_safe_redirect(get_admin_url(), 301);
                                exit;
                            }
                            break;
                    }
                }
            );

            /* removes Post Type `Post` related menus from the sidebar menu */
            add_action(
                'admin_menu',
                function () {
                    global $menu, $submenu;

                    /*
                        edit.php
                        post-new.php
                        edit-tags.php?taxonomy=category
                        edit-tags.php?taxonomy=post_tag
                     */

                    $done = false;
                    foreach ($menu as $k => $v) {
                        foreach ($v as $key => $val) {
                            switch ($val) {
                                case 'Posts':
                                    unset($menu[$k]);
                                    $done = true;
                                    break;
                            }
                        }
                        /* bail out as soon as we are done */
                        if ($done) {
                            break;
                        }
                    }
                    $done = false;
                    foreach ($submenu as $k => $v) {
                        switch ($k) {
                            case 'edit.php':
                                unset($submenu[$k]);
                                $done = true;
                                break;
                        }
                        /* bail out as soon as we are done */
                        if ($done) {
                            break;
                        }
                    }
                }
            );

            global $pagenow;

            if (!is_admin() && ($pagenow !== 'wp-login.php')) {
                /* need to return a 404 when post_type `post` objects are found */
                add_action(
                    'posts_results',
                    function ($posts = []) {
                        global $wp_query;

                        $look_for = "wp_posts.post_type = 'post'";
                        $instance = strpos($wp_query->request, $look_for);
                        /*
                            http://localhost/?m=2013		- yearly archives
                            http://localhost/?m=201303		- monthly archives
                            http://localhost/?m=20130327	- daily archives
                            http://localhost/?cat=1			- category archives
                            http://localhost/?tag=foobar	- tag archives
                            http://localhost/?p=1			- single post
                        */
                        if ($instance !== false) {
                            $posts = []; // we are querying for post type `post`
                        }

                        return $posts;
                    }
                );
            }
        }
    }
}
