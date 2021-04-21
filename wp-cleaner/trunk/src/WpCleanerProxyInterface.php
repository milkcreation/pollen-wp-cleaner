<?php

declare(strict_types=1);

namespace Pollen\WpCleaner;

interface WpCleanerProxyInterface
{
    /**
     * Instance du gestionnaire de nettoyage Wordpress.
     *
     * @return WpCleanerInterface|null
     */
    public function wpCleaner(): ?WpCleanerInterface;

    /**
     * Définition du gestionnaire de nettoyage Wordpress.
     *
     * @param WpCleanerInterface $wpCleaner
     *
     * @return WpCleanerProxy
     */
    public function setWpCleaner(WpCleanerInterface $wpCleaner): WpCleanerProxy;
}