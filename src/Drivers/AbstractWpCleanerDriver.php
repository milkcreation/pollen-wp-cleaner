<?php

declare(strict_types=1);

namespace Pollen\WpCleaner\Drivers;

use Pollen\WpCleaner\WpCleanerInterface;
use Pollen\WpCleaner\WpCleanerProxy;

abstract class AbstractWpCleanerDriver implements WpCleanerDriverInterface
{
    use WpCleanerProxy;

    /**
     * @param WpCleanerInterface $wpCleaner
     */
    public function __construct(WpCleanerInterface $wpCleaner)
    {
        $this->setWpCleaner($wpCleaner);
    }
}