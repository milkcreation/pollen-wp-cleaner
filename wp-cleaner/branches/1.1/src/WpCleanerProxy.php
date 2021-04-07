<?php

declare(strict_types=1);

namespace Pollen\WpCleaner;

use Pollen\Support\StaticProxy;
use RuntimeException;

/**
 * @see \Pollen\WpCleaner\WpCleanerProxyInterface
 */
trait WpCleanerProxy
{
    /**
     * Instance du gestionnaire de nettoyage Wordpress.
     * @var WpCleanerInterface
     */
    private $wpCleaner;

    /**
     * Instance du gestionnaire de nettoyage Wordpress.
     *
     * @return WpCleanerInterface
     */
    public function wpCleaner(): WpCleanerInterface
    {
        if ($this->wpCleaner === null) {
            try {
                $this->wpCleaner = WpCleaner::getInstance();
            } catch (RuntimeException $e) {
                $this->wpCleaner = StaticProxy::getProxyInstance(
                    WpCleanerInterface::class,
                    WpCleaner::class,
                    method_exists($this, 'getContainer') ? $this->getContainer() : null
                );
            }
        }

        return $this->wpCleaner;
    }

    /**
     * Définition de l'instance du gestionnaire de nettoyage Wordpress.
     *
     * @param WpCleanerInterface $wpCleaner
     *
     * @return void
     */
    public function setWpCleaner(WpCleanerInterface $wpCleaner): void
    {
        $this->wpCleaner = $wpCleaner;
    }
}
