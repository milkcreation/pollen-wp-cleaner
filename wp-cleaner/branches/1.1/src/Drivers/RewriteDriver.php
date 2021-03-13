<?php

declare(strict_types=1);

namespace Pollen\WpCleaner\Drivers;

use Pollen\WpCleaner\AbstractWpCleanerDriver;

class RewriteDriver extends AbstractWpCleanerDriver
{
    /**
     * @inheritDoc
     */
    public function boot(): void
    {
        /**
         * DEBUG
         * @see {{ site_url }}/?debug=rewrite_rules
         */
        add_action(
            'template_redirect',
            function () {
                if (
                    isset($_REQUEST['debug']) &&
                    $_REQUEST['debug'] === 'rewrite_rules' &&
                    is_user_logged_in() &&
                    in_array('administrator', wp_get_current_user()->roles)
                ) {
                    echo json_encode(get_option('rewrite_rules'));
                    exit;
                }
            },
            0
        );
        /**/

        if ($removedRules = (array)$this->wpCleaner()->config('remove_rewrite_rules', [])) {
            foreach ($removedRules as $removedRule) {
                add_filter(
                    "{$removedRule}_rewrite_rules",
                    function () {
                        return [];
                    }
                );
            }
        }
    }
}