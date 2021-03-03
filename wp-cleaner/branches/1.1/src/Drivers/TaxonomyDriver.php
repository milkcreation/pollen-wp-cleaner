<?php

declare(strict_types=1);

namespace Pollen\WpCleaner\Drivers;

class TaxonomyDriver extends AbstractWpCleanerDriver
{
    /**
     * @inheritDoc
     */
    public function boot(): void
    {
        if ($this->wpCleaner()->config('disable_post_category') === true) {
            add_action(
                'init',
                function () {
                    global $wp_taxonomies;

                    if (isset($wp_taxonomies['category'])) {
                        $wp_taxonomies['category']->show_in_nav_menus = false;
                    }
                    unregister_taxonomy_for_object_type('category', 'post');
                }
            );
        }

        if ($this->wpCleaner()->config('disable_post_tag', false) === true) {
            add_action(
                'init',
                function () {
                    global $wp_taxonomies;

                    if (isset($wp_taxonomies['post_tag'])) {
                        $wp_taxonomies['post_tag']->show_in_nav_menus = false;
                    }
                    unregister_taxonomy_for_object_type('post_tag', 'post');
                }
            );
        }

        add_action(
            'init',
            function () {
                global $wp_taxonomies;

                $configKeys = $this->wpCleaner()->config()->keys();

                foreach ($configKeys as $key) {
                    if (!preg_match('/^unregister_taxonomy_for_(.*)/', $key, $match)) {
                        continue;
                    }
                    $post_type = $match[1];

                    if (!post_type_exists($post_type)) {
                        continue;
                    }

                    foreach ($this->wpCleaner()->config($key, []) as $taxonomy) {
                        if (isset($wp_taxonomies[$taxonomy])) {
                            $wp_taxonomies[$taxonomy]->show_in_nav_menus = false;
                        }
                        unregister_taxonomy_for_object_type($taxonomy, $post_type);
                    }
                }
            },
            999999
        );
    }
}