<?php

declare(strict_types=1);

namespace Pollen\WpCleaner\Drivers;

use Pollen\WpCleaner\AbstractWpCleanerDriver;
use WP_Sitemaps_Provider;

class SitemapDriver extends AbstractWpCleanerDriver
{
    /**
     * @inheritDoc
     */
    public function boot(): void
    {
        if ($removedProviders = (array)$this->wpCleaner()->config('remove_sitemap_providers', [])) {
            add_filter(
                'wp_sitemaps_add_provider',
                function (WP_Sitemaps_Provider $provider, string $name) use ($removedProviders) {
                    if (in_array($name, $removedProviders, true)) {
                        return null;
                    }
                    return $provider;
                },
                10,
                2
            );
        }

        if ($removedPostTypes = (array)$this->wpCleaner()->config('remove_sitemap_post_types', [])) {
            add_filter('wp_sitemaps_post_types', function ($post_types) use ($removedPostTypes) {
                foreach($removedPostTypes as $removedPostType) {
                    if (isset($post_types[$removedPostType])) {
                        unset($post_types[$removedPostType]);
                    }
                }
                return $post_types;
            });
        }

        if ($removedTaxonomies = (array)$this->wpCleaner()->config('remove_sitemap_taxonomies', [])) {
            add_filter('wp_sitemaps_taxonomies', function ($taxonomies) use ($removedTaxonomies) {
                foreach($removedTaxonomies as $removedTaxonomy) {
                    if (isset($taxonomies[$removedTaxonomy])) {
                        unset($taxonomies[$removedTaxonomy]);
                    }
                }
                return $taxonomies;
            });
        }
    }
}