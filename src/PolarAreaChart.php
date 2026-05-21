<?php

namespace vnusWilliams\LarapexCharts;


use vnusWilliams\LarapexCharts\Contracts\MustAddSimpleData;
use vnusWilliams\LarapexCharts\Traits\SimpleChartDataAggregator;

class PolarAreaChart extends LarapexChart implements MustAddSimpleData
{
    use SimpleChartDataAggregator;

    public function __construct()
    {
        parent::__construct();
        $this->type = 'polarArea';
    }
}