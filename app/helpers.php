<?php

function percentageDifference(float $old, float $new): float
{
    return (($new - $old) / abs($old)) * 100;
}
