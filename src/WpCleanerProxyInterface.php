<?php

declare(strict_types=1);

namespace Pollen\WpCleaner;

interface WpCleanerProxyInterface
{
    /**
     * Instance du gestionnaire de nettoyage Wordpress.
     *
     * @return WpCleanerInterface
     */
    public function wpCleaner(): WpCleanerInterface;

    /**
     * Définition du gestionnaire de nettoyage Wordpress.
     *
     * @param WpCleanerInterface $wpCleaner
     *
     * @return void
     */
    public function setWpCleaner(WpCleanerInterface $wpCleaner): void;
}
