<?php

declare(strict_types=1);

namespace Pollen\WpCleaner\Drivers;

class EmbedDriver extends AbstractWpCleanerDriver
{
    /**
     * Liste des options de désactivation des éléments de l'embed.
     * @var array
     */
    protected $attributes = [
        'register_route'    => true,
        'discover'          => true,
        'filter_result'     => true,
        'discovery_links'   => true,
        'host_js'           => true,
        'tiny_mce_plugin'   => true,
        'pre_oembed_result' => true,
        'rewrite_rules'     => true,
        'dequeue_script'    => true,
    ];

    /**
     * @inheritDoc
     */
    public function boot(): void
    {
        if ($disable_embed = $this->wpCleaner()->config('disable_embed', [])) {
            $this->attributes = ($disable_embed === true) ? $this->attributes : array_merge(
                $this->attributes,
                $disable_embed
            );

            add_action(
                'init',
                function () {
                    // Remove the REST API endpoint.
                    if ($this->attributes['register_route']) {
                        remove_action('rest_api_init', 'wp_oembed_register_route');
                    }

                    // Turn off oEmbed auto discovery.
                    if ($this->attributes['discover']) {
                        add_filter('embed_oembed_discover', '__return_false');
                    }

                    // Don't filter oEmbed results.
                    if ($this->attributes['filter_result']) {
                        remove_filter('oembed_dataparse', 'wp_filter_oembed_result');
                    }

                    // Remove oEmbed discovery links.
                    if ($this->attributes['discovery_links']) {
                        remove_action('wp_head', 'wp_oembed_add_discovery_links');
                    }

                    // Remove oEmbed-specific JavaScript from the front-end and back-end.
                    if ($this->attributes['host_js']) {
                        remove_action('wp_head', 'wp_oembed_add_host_js');
                    }
                    if ($this->attributes['tiny_mce_plugin']) {
                        add_filter(
                            'tiny_mce_plugins',
                            function (array $plugins) {
                                return array_diff($plugins, ['wpembed']);
                            }
                        );
                    }

                    // Remove filter of the oEmbed result before any HTTP requests are made.
                    if ($this->attributes['pre_oembed_result']) {
                        remove_filter('pre_oembed_result', 'wp_filter_pre_oembed_result');
                    }

                    // Retire les régles de réécriture.
                    if ($this->attributes['rewrite_rules']) {
                        add_filter(
                            'rewrite_rules_array',
                            function (array $rules) {
                                foreach ($rules as $rule => $rewrite) {
                                    if (false !== strpos($rewrite, 'embed=true')) {
                                        unset($rules[$rule]);
                                    }
                                }
                                return $rules;
                            }
                        );
                    }

                    // Retire le script d'intégration de la file.
                    if ($this->attributes['dequeue_script']) {
                        add_action(
                            'wp_footer',
                            function () {
                                wp_dequeue_script('wp-embed');
                            }
                        );
                    }
                },
                999999
            );
        }
    }
}
