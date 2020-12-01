<?php

namespace App\Observers;

use App\Entities\Imports;
use Illuminate\Support\Facades\Log;

class ImportsObserver
{
    public function created(Imports $imports)
    {
        Log::notice('The user number '. $imports->created_by.' had been imported '. $imports->count);
    }
}
