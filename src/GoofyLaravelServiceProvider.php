<?php

namespace Eduzz\Goofy;

use Eduzz\Goofy\Goofy;
use Eduzz\Hermes\Hermes;

use Illuminate\Support\ServiceProvider;

class GoofyLaravelServiceProvider extends ServiceProvider
{
    protected $defer = true;

    public function boot()
    {
        $this->publishes(
            [
            __DIR__ . '/Config/goofy.php' => $this->getConfigPath('goofy.php'),
            ], 'config'
        );
    }

    public function register()
    {
        $this->app->bind(
            'Eduzz\Goofy\Goofy', function ($app) {
                $hermes = new Hermes(config('goofy.queue_connection'));

                $goofy = new Goofy(
                    config('goofy.application'),
                    $hermes
                );

                return $goofy;
            }
        );
    }

    /**
     * Get the configuration file path.
     *
     * @param  string $path
     * @return string
     */
    private function getConfigPath($path = '') 
    {
        return $this->app->basePath() . '/config' . ($path ? '/' . $path : $path);
    }

    public function provides()
    {
        return [Goofy::class];
    }
}
