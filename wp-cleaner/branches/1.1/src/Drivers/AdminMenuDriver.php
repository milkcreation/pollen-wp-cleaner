<?php

declare(strict_types=1);

namespace Pollen\WpCleaner\Drivers;

class AdminMenuDriver extends AbstractWpCleanerDriver
{
    /**
     * @inheritDoc
     */
    public function boot(): void
    {
        if ($removed_menus = $this->wpCleaner()->config('remove_menu', [])) {
            add_action(
                'admin_menu',
                function () use ($removed_menus) {
                    foreach ($removed_menus as $removed_menu) {
                        switch ($removed_menu) {
                            default:
                                remove_menu_page($removed_menu);
                                break;
                            case 'dashboard':
                                remove_menu_page('index.php');
                                break;
                            case 'posts':
                                remove_menu_page('edit.php');
                                break;
                            case 'media':
                                remove_menu_page('upload.php');
                                break;
                            case 'pages':
                                remove_menu_page('edit.php?post_type=page');
                                break;
                            case 'comments':
                                remove_menu_page('edit-comments.php');
                                break;
                            case 'appearence':
                                remove_menu_page('themes.php');
                                break;
                            case 'plugins':
                                remove_menu_page('plugins.php');
                                break;
                            case 'users':
                                remove_menu_page('users.php');
                                break;
                            case 'tools':
                                remove_menu_page('tools.php');
                                break;
                            case 'settings':
                                remove_menu_page('options-general.php');
                                break;
                        }
                    }
                }
            );
        }
    }
}
