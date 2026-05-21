<?php

namespace vnusWilliams\LarapexCharts;

use vnusWilliams\LarapexCharts\Contracts\MustAddComplexData;
use vnusWilliams\LarapexCharts\Traits\ComplexChartDataAggregator;

class BarChart extends LarapexChart implements MustAddComplexData
{
    use ComplexChartDataAggregator;

    public function __construct()
    {
        parent::__construct();
        $this->type = 'bar';
    }
}