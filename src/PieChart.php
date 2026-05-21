<?php

namespace vnusWilliams\LarapexCharts;


use vnusWilliams\LarapexCharts\Contracts\MustAddSimpleData;
use vnusWilliams\LarapexCharts\Traits\SimpleChartDataAggregator;

class PieChart extends LarapexChart implements MustAddSimpleData
{
    use SimpleChartDataAggregator;

    public function __construct()
    {
        parent::__construct();
        $this->type = 'pie';
    }
}