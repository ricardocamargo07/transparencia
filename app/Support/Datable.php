<?php

namespace App\Support;

use Carbon\Carbon;

trait Datable
{
    public function convertDate($date)
    {
        if (! $date) {
            return null;
        }

        return Carbon::parse($date);
    }
}
