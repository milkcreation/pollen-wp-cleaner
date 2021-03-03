<?php
declare(strict_types=1);

namespace Pollen\WpConfig;

use RuntimeException;
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
use Psr\Container\ContainerInterface as Container;
use tiFy\Contracts\Filesystem\LocalFilesystem;
use tiFy\Support\Concerns\BootableTrait;
use tiFy\Support\Concerns\ContainerAwareTrait;
use tiFy\Support\ParamsBag;
use tiFy\Support\Proxy\Storage;

class WpConfig implements WpConfigContract
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
    public static function instance(): WpConfigContract
    {
        if (self::$instance instanceof self) {
            return self::$instance;
        }
        throw new RuntimeException(sprintf('Unavailable %s instance', __CLASS__));
    }

    /**
     * @inheritDoc
     */
    public function boot(): WpConfigContract
    {
        if (!$this->isBooted()) {
            events()->trigger('wp-config.booting', [$this]);

            foreach($this->drivers as $driver) {
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
        } elseif (is_array($key)) {
            return $this->configBag->set($key);
        } else {
            return $this->configBag;
        }
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
    public function setConfig(array $attrs): WpConfigContract
    {
        $this->config($attrs);

        return $this;
    }
}
