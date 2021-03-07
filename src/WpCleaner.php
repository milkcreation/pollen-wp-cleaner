<?php

declare(strict_types=1);

namespace Pollen\WpCleaner;

use Pollen\Support\Filesystem;
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
use Psr\Container\ContainerInterface as Container;
use Pollen\Support\Concerns\BootableTrait;
use Pollen\Support\Concerns\ConfigBagAwareTrait;
use Pollen\Support\Proxy\ContainerProxy;
use RuntimeException;

class WpCleaner implements WpCleanerInterface
{
    use BootableTrait;
    use ConfigBagAwareTrait;
    use ContainerProxy;

    /**
     * Instance principale.
     * @var static|null
     */
    private static $instance;

    /**
     * Chemin vers le répertoire des ressources.
     * @var string|null
     */
    protected $resourcesBaseDir;

    /**
     * Liste des pilotes.
     * @var array
     */
    protected $drivers = [
        AdminBarDriver::class,
        AdminFooterDriver::class,
        AdminMenuDriver::class,
        CommentsDriver::class,
        DashboardDriver::class,
        DNSPrefetchDriver::class,
        EmbedDriver::class,
        EmojiDriver::class,
        MetaTagDriver::class,
        PostTypeDriver::class,
        RestApiDriver::class,
        TaxonomyDriver::class,
        WidgetDriver::class,
    ];

    /**
     * @param array $config
     * @param Container|null $container
     *
     * @return void
     */
    public function __construct(array $config = [], Container $container = null)
    {
        $this->setConfig($config);

        if ($container !== null) {
            $this->setContainer($container);
        }

        if ($this->config('boot_enabled', true)) {
            $this->boot();
        }

        if (!self::$instance instanceof static) {
            self::$instance = $this;
        }
    }

    /**
     * Récupération de l'instance principale.
     *
     * @return static
     */
    public static function getInstance(): WpCleanerInterface
    {
        if (self::$instance instanceof self) {
            return self::$instance;
        }
        throw new RuntimeException(sprintf('Unavailable [%s] instance', __CLASS__));
    }

    /**
     * @inheritDoc
     */
    public function boot(): WpCleanerInterface
    {
        if (!$this->isBooted()) {
            //events()->trigger('wp-config.booting', [$this]);

            add_action('after_setup_theme', function () {
                foreach ($this->drivers as $driver) {
                    $driver = $this->containerHas($driver) ? $this->containerGet($driver) : new $driver($this);
                    $driver->boot();
                }
            });

            $this->setBooted();

            //events()->trigger('wp-config.booted', [$this]);
        }
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function resources(?string $path = null): string
    {
        if ($this->resourcesBaseDir === null) {
            $this->resourcesBaseDir = Filesystem::normalizePath(realpath(dirname(__DIR__) . '/resources/'));

            if (!file_exists($this->resourcesBaseDir)) {
                throw new RuntimeException('WpCleaner ressources directory unreachable');
            }
        }

        return is_null($path) ? $this->resourcesBaseDir : $this->resourcesBaseDir . Filesystem::normalizePath($path);
    }

    /**
     * @inheritDoc
     */
    public function setResourcesBaseDir(string $resourceBaseDir): WpCleanerInterface
    {
        $this->resourcesBaseDir = Filesystem::normalizePath($resourceBaseDir);

        return $this;
    }
}
