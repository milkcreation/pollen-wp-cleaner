<?php

declare(strict_types=1);

namespace Pollen\WpCleaner;

use Pollen\WpCleaner\Drivers\AdminBarDriver;
use Pollen\WpCleaner\Drivers\AdminFooterDriver;
use Pollen\WpCleaner\Drivers\AdminMenuDriver;
use Pollen\WpCleaner\Drivers\CommentsDriver;
use Pollen\WpCleaner\Drivers\DashboardDriver;
use Pollen\WpCleaner\Drivers\DNSPrefetchDriver;
use Pollen\WpCleaner\Drivers\EmbedDriver;
use Pollen\WpCleaner\Drivers\EmojiDriver;
use Pollen\WpCleaner\Drivers\MetaTagDriver;
use Pollen\WpCleaner\Drivers\PostTypeDriver;
use Pollen\WpCleaner\Drivers\RestApiDriver;
use Pollen\WpCleaner\Drivers\TaxonomyDriver;
use Pollen\WpCleaner\Drivers\WidgetDriver;
use tiFy\Container\ServiceProvider;

class WpCleanerServiceProvider extends ServiceProvider
{
    /**
     * Liste des noms de qualification des services fournis.
     * @internal requis. Tous les noms de qualification de services à traiter doivent être renseignés.
     * @var string[]
     */
    protected $provides = [
        WpCleanerInterface::class
    ];

    /**
     * @inheritdoc
     */
    public function boot(): void
    {
        events()->listen('wp.booted', function () {
            $this->getContainer()->get(WpCleanerInterface::class)->boot();
        });
    }

    /**
     * @inheritdoc
     */
    public function register(): void
    {
        $this->getContainer()->share(WpCleanerInterface::class, function() {
            return new WpCleaner(config('wp-config', []), $this->getContainer());
        });
    }

    /**
     * Déclaration des pilotes.
     *
     * @return void
     */
    public function registerDrivers(): void
    {
        $this->getContainer()->share(AdminBarDriver::class, function() {
            return new AdminBarDriver($this->getContainer()->get(WpCleanerInterface::class));
        });

        $this->getContainer()->share(AdminFooterDriver::class, function() {
            return new AdminFooterDriver($this->getContainer()->get(WpCleanerInterface::class));
        });

        $this->getContainer()->share(AdminMenuDriver::class, function() {
            return new AdminMenuDriver($this->getContainer()->get(WpCleanerInterface::class));
        });

        $this->getContainer()->share(CommentsDriver::class, function() {
            return new CommentsDriver($this->getContainer()->get(WpCleanerInterface::class));
        });

        $this->getContainer()->share(DashboardDriver::class, function() {
            return new DashboardDriver($this->getContainer()->get(WpCleanerInterface::class));
        });

        $this->getContainer()->share(DNSPrefetchDriver::class, function() {
            return new DNSPrefetchDriver($this->getContainer()->get(WpCleanerInterface::class));
        });

        $this->getContainer()->share(EmbedDriver::class, function() {
            return new EmbedDriver($this->getContainer()->get(WpCleanerInterface::class));
        });

        $this->getContainer()->share(EmojiDriver::class, function() {
            return new EmojiDriver($this->getContainer()->get(WpCleanerInterface::class));
        });

        $this->getContainer()->share(MetaTagDriver::class, function() {
            return new MetaTagDriver($this->getContainer()->get(WpCleanerInterface::class));
        });

        $this->getContainer()->share(PostTypeDriver::class, function() {
            return new PostTypeDriver($this->getContainer()->get(WpCleanerInterface::class));
        });

        $this->getContainer()->share(RestApiDriver::class, function() {
            return new RestApiDriver($this->getContainer()->get(WpCleanerInterface::class));
        });

        $this->getContainer()->share(TaxonomyDriver::class, function() {
            return new TaxonomyDriver($this->getContainer()->get(WpCleanerInterface::class));
        });

        $this->getContainer()->share(WidgetDriver::class, function() {
            return new WidgetDriver($this->getContainer()->get(WpCleanerInterface::class));
        });
    }
}