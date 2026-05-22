<?php

namespace vnusWilliams\LarapexCharts;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class LarapexChartsServiceProvider extends ServiceProvider
{

    /**
     * Before laravel app get all providers and methods of laravel running 
     * The package must register the service to access to package class service container and Facade
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('larapex-chart', function () {
            return new LarapexChart;
        });

        $this->mergeConfigFrom($this->packageBasePath('config/larapex-charts.php'), 'larapex-charts');

        $this->commands([
            \vnusWilliams\LarapexCharts\Console\ChartMakeCommand::class,
        ]);
    }

    /**
     * When this method is apply we have all laravel providers and methods available
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom($this->packageBasePath('stubs/resources/views'), 'larapex-charts');

        $this->publishes([
            $this->packageBasePath('stubs/public') => public_path('vendor/larapex-charts')
        ], 'larapex-charts-apexcharts-script');

        $this->publishes([
            $this->packageBasePath('stubs/resources/views') => resource_path('views/vendor/larapex-charts')
        ], 'larapex-charts-views');

        $this->publishes([
            $this->packageBasePath('config/larapex-charts.php') => base_path('config/larapex-charts.php')
        ], 'larapex-charts-config');        

        $this->publishes([
            $this->packageBasePath('stubs/Console/Commands') => app_path('Console/Commands')
        ], 'larapex-charts-commands');

        $this->publishes([
            $this->packageBasePath('stubs/stubs') => base_path('stubs')
        ], 'larapex-charts-stubs');

        /*
        |--------------------------------------------------------------------------
        | @larapexChartScripts Blade Directive
        |--------------------------------------------------------------------------
        |
        | Place @larapexChartScripts just before </body> in your main layout.
        | It scans the page for every [data-larapex-chart] element and initializes
        | the corresponding ApexChart instance. If no chart elements are found,
        | nothing is rendered — zero overhead for pages without charts.
        |
        */
        Blade::directive('larapexChartScripts', function () {
            return "<?php echo view('larapex-charts::chart.scripts')->render(); ?>";
        });
    }

    public function packageBasePath(string $path = ''): string
    {
        return __DIR__ . '/../' . $path;
    }

}