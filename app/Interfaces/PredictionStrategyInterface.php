<?php

namespace Bank\Interfaces;


Interface PredictionStrategyInterface
{
    public function calculateMinSpend(int $min = 0);

    public function calculateMaxSpend(int $max = 9999);

    public function canSkipIfSkint(bool $canSkip = false);

    public function isValidOnDays(array $days = ['all']);

}
