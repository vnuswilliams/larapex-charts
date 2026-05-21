<?php

namespace vnusWilliams\LarapexCharts\Contracts;


interface MustAddSimpleData
{
    public function addData(array $data) :self;
}