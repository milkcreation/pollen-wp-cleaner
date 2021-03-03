<?php declare(strict_types=1);

namespace Pollen\WpConfig;

use Pollen\WpConfig\Contracts\WpConfigContract;
use Pollen\WpConfig\Drivers\AdminBarDriver;
use Pollen\WpConfig\Drivers\AdminFooterDriver;
use Pollen\WpConfig\Drivers\AdminMenuDriver;
use Pollen\WpConfig\Drivers\CommentsDriver;
use Pollen\WpConfig\Drivers\DashboardDriver;
use Pollen\WpConfig\Drivers\DNSPrefetchDriver;
use Pollen\WpConfig\Drivers\EmbedDriver;
use Pollen\WpConfig\Drivers\EmojiDriver;
use Pollen\WpConfig\Drivers\MetaTagDriver;
use Pollen\WpConfig\Drivers\PostTypeDriver;
use Pollen\WpConfig\Drivers\RestApiDriver;
use Pollen\WpConfig\Drivers\TaxonomyDriver;
use Pollen\WpConfig\Drivers\WidgetDriver;
use tiFy\Container\ServiceProvider;

class WpConfigServiceProvider extends ServiceProvider
{
    /**
     * Liste des noms de qualification des services fournis.
     * @internal requis. Tous les noms de qualification de services à traiter doivent être renseignés.
     * @var string[]
     */
    protected $provides = [
        WpConfigContract::class
    ];

    /**
     * @inheritdoc
     */
    public function boot(): void
    {
        events()->listen('wp.booted', function () {
            $this->getContainer()->get(WpConfigContract::class)->boot();
        });
    }

    /**
     * @inheritdoc
     */
    public function register(): void
    {
        $this->getContainer()->share(WpConfigContract::class, function() {
            return new WpConfig(config('wp-config', []), $this->getContainer());
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
            return new AdminBarDriver($this->getContainer()->get(WpConfigContract::class));
        });

        $this->getContainer()->share(AdminFooterDriver::class, function() {
            return new AdminFooterDriver($this->getContainer()->get(WpConfigContract::class));
        });

        $this->getContainer()->share(AdminMenuDriver::class, function() {
            return new AdminMenuDriver($this->getContainer()->get(WpConfigContract::class));
        });

        $this->getContainer()->share(CommentsDriver::class, function() {
            return new CommentsDriver($this->getContainer()->get(WpConfigContract::class));
        });

        $this->getContainer()->share(DashboardDriver::class, function() {
            return new DashboardDriver($this->getContainer()->get(WpConfigContract::class));
        });

        $this->getContainer()->share(DNSPrefetchDriver::class, function() {
            return new DNSPrefetchDriver($this->getContainer()->get(WpConfigContract::class));
        });

        $this->getContainer()->share(EmbedDriver::class, function() {
            return new EmbedDriver($this->getContainer()->get(WpConfigContract::class));
        });

        $this->getContainer()->share(EmojiDriver::class, function() {
            return new EmojiDriver($this->getContainer()->get(WpConfigContract::class));
        });

        $this->getContainer()->share(MetaTagDriver::class, function() {
            return new MetaTagDriver($this->getContainer()->get(WpConfigContract::class));
        });

        $this->getContainer()->share(PostTypeDriver::class, function() {
            return new PostTypeDriver($this->getContainer()->get(WpConfigContract::class));
        });

        $this->getContainer()->share(RestApiDriver::class, function() {
            return new RestApiDriver($this->getContainer()->get(WpConfigContract::class));
        });

        $this->getContainer()->share(TaxonomyDriver::class, function() {
            return new TaxonomyDriver($this->getContainer()->get(WpConfigContract::class));
        });

        $this->getContainer()->share(WidgetDriver::class, function() {
            return new WidgetDriver($this->getContainer()->get(WpConfigContract::class));
        });
    }
}