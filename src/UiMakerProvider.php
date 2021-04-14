<?php

namespace SmartContact\UiMaker;

use SmartContact\UiMaker\console\MakeUi;
use SmartContact\UiMaker\console\InstallCommand;
use SmartContact\UiMaker\modules\UIBaseContract;
use Illuminate\Support\Str;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class UiMakerProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        app()->singleton(UIBaseContract::class, function() {
            $resource = request()->route('resource');
            $class = "App\Modules\Ui\Ui" . Str::ucfirst(Str::singular($resource));
            return new $class();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                MakeUi::class
            ]);
        }

        $this->loadRoutesFrom(__DIR__ . '/routes/routes.php');
    }
}
