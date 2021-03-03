<?php declare(strict_types=1);

namespace Pollen\WpConfig\Drivers;

use Pollen\WpConfig\Contracts\WpConfigContract;
use Pollen\WpConfig\WpConfigAwareTrait;

abstract class AbstractWpConfigDriver implements WpConfigDriverInterface
{
    use WpConfigAwareTrait;

    /**
     * @param WpConfigContract $wpConfigManager
     */
    public function __construct(WpConfigContract $wpConfigManager)
    {
        $this->setWpConfig($wpConfigManager);
    }
}