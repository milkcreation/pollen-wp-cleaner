<?php declare(strict_types=1);

namespace Pollen\WpConfig;

use Exception;
use Pollen\WpConfig\Contracts\WpConfigContract;

trait WpConfigAwareTrait
{
    /**
     * Instance du gestionnaire.
     * @var WpConfigContract|null
     */
    private $wpConfig;

    /**
     * Récupération de l'instance du gestionnaire.
     *
     * @return WpConfigContract|null
     */
    public function wpConfig(): ?WpConfigContract
    {
        if (is_null($this->wpConfig)) {
            try {
                $this->wpConfig = WpConfig::instance();
            } catch (Exception $e) {
                $this->wpConfig;
            }
        }
        return $this->wpConfig;
    }

    /**
     * Définition de l'application.
     *
     * @param WpConfigContract $wpConfig
     *
     * @return static
     */
    public function setWpConfig(WpConfigContract $wpConfig): self
    {
        $this->wpConfig = $wpConfig;

        return $this;
    }
}
