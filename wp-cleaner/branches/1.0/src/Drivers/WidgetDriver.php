<?php

declare(strict_types=1);

namespace Pollen\WpConfig\Drivers;

class WidgetDriver extends AbstractWpConfigDriver
{
    /**
     * @inheritDoc
     */
    public function boot(): void
    {
        if ($widgets = $this->wpConfig()->config('unregister_widget', [])) {
            add_action(
                'widget_init',
                function () use ($widgets) {
                    foreach ($widgets as $widget) {
                        switch ($widget) {
                            default:
                                unregister_widget($widget);
                                break;
                            case 'pages':
                            case 'calendar':
                            case 'archives':
                            case 'links':
                            case 'meta':
                            case 'search':
                            case 'text':
                            case 'categories':
                            case 'recent posts':
                            case 'recent comments':
                            case 'tag cloud':
                                unregister_widget('WP_Widget_' . preg_replace('/\s/', '_', ucwords($widget)));
                                break;
                            case 'rss' :
                                unregister_widget('WP_Widget_' . preg_replace('/\s/', '_', ucwords($widget)));
                                unregister_widget('WP_Widget_RSS');
                                break;
                            case 'nav menu' :
                                unregister_widget('WP_Widget_' . preg_replace('/\s/', '_', ucwords($widget)));
                                unregister_widget('WP_Nav_Menu_Widget');
                                break;
                        }
                    }
                }
            );
        }
    }
}