<?php


namespace vnusWilliams\LarapexCharts\Traits;


use vnusWilliams\LarapexCharts\LarapexChart;

trait SimpleChartDataAggregator
{
    public function addData(array $data) :self
    {
        $this->dataset = json_encode($data);

        return $this;
    }
}