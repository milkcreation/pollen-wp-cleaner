<?php

declare(strict_types=1);

namespace Pollen\WpCleaner;

use Exception;

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
     * @return WpCleanerInterface|null
     */
    public function wpCleaner(): ?WpCleanerInterface
    {
        if (is_null($this->wpCleaner)) {
            try {
                $this->wpCleaner = WpCleaner::instance();
            } catch (Exception $e) {
                $this->wpCleaner;
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
