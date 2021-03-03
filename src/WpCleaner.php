<?php

declare(strict_types=1);

namespace Pollen\WpCleaner;

use RuntimeException;
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
use tiFy\Contracts\Filesystem\LocalFilesystem;
use tiFy\Support\Concerns\BootableTrait;
use tiFy\Support\Concerns\ContainerAwareTrait;
use tiFy\Support\ParamsBag;
use tiFy\Support\Proxy\Storage;

class WpCleaner implements WpCleanerInterface
{
    use BootableTrait;
    use ContainerAwareTrait;

    /**
     * Instance de la classe.
     * @var static|null
     */
    private static $instance;

    /**
     * Instance du gestionnaire de configuration.
     * @var ParamsBag
     */
    private $configBag;

    /**
     * Instance du gestionnaire des ressources
     * @var LocalFilesystem|null
     */
    private $resources;

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

        if (!is_null($container)) {
            $this->setContainer($container);
        }

        if (!self::$instance instanceof static) {
            self::$instance = $this;
        }
    }

    /**
     * @inheritDoc
     */
    public static function instance(): WpCleanerInterface
    {
        if (self::$instance instanceof self) {
            return self::$instance;
        }
        throw new RuntimeException(sprintf('Unavailable %s instance', __CLASS__));
    }

    /**
     * @inheritDoc
     */
    public function boot(): WpCleanerInterface
    {
        if (!$this->isBooted()) {
            events()->trigger('wp-config.booting', [$this]);

            foreach ($this->drivers as $driver) {
                $driver = $this->containerHas($driver) ? $this->containerGet($driver) : new $driver($this);
                $driver->boot();
            }

            $this->setBooted();

            events()->trigger('wp-config.booted', [$this]);
        }
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function config($key = null, $default = null)
    {
        if (!isset($this->configBag) || is_null($this->configBag)) {
            $this->configBag = new ParamsBag();
        }

        if (is_string($key)) {
            return $this->configBag->get($key, $default);
        }
        if (is_array($key)) {
            return $this->configBag->set($key);
        }
        return $this->configBag;
    }

    /**
     * @inheritDoc
     */
    public function resources(?string $path = null)
    {
        if (!isset($this->resources) || is_null($this->resources)) {
            $this->resources = Storage::local(dirname(__DIR__) . DIRECTORY_SEPARATOR . 'resources');
        }

        return is_null($path) ? $this->resources : $this->resources->path($path);
    }

    /**
     * @inheritDoc
     */
    public function setConfig(array $attrs): WpCleanerInterface
    {
        $this->config($attrs);

        return $this;
    }
}
