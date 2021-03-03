<?php

declare(strict_types=1);

namespace Pollen\WpCleaner;

use Psr\Container\ContainerInterface as Container;
use RuntimeException;

trait WpCleanerProxy
{
    /**
     * Instance du gestionnaire de nettoyage Wordpress.
     * @var WpCleanerInterface|null
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
            $container = method_exists($this, 'getContainer') ? $this->getContainer() : null;

            if ($container instanceof Container && $container->has(WpCleanerInterface::class)) {
                $this->wpCleaner = $container->get(WpCleanerInterface::class);
            } else {
                try {
                    $this->wpCleaner = WpCleaner::getInstance();
                } catch(RuntimeException $e) {
                    $this->wpCleaner = new WpCleaner();
                }
            }
        }

        return $this->wpCleaner;
    }

    /**
     * Définition de l'instance du gestionnaire de nettoyage Wordpress.
     *
     * @param WpCleanerInterface $wpCleaner
     *
     * @return static
     */
    public function setWpCleaner(WpCleanerInterface $wpCleaner): WpCleanerProxy
    {
        $this->wpCleaner = $wpCleaner;

        return $this;
    }
}
