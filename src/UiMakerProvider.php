<?php

namespace SmartContact\UiMaker;

use SmartContact\UiMaker\console\MakeUi;
use SmartContact\UiMaker\console\InstallCommand;
use SmartContact\UiMaker\modules\ToMicroservice;
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
            $microservice = request()->route('microservice');
            $resource = request()->route('resource');
            $isFinalMicroservice = request()->is_final_microservice || $microservice == 'api-gateway';
            if($isFinalMicroservice) {
                $class = "App\Modules\Ui\Ui" . Str::ucfirst(Str::singular($resource));
                return new $class();
            }

            $url = "";
            //$url = retrieveBaseUrlBy($microservice);
            return new ToMicroservice($url);
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
