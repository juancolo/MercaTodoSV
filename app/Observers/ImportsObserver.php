<?php

namespace App\Observers;

use App\Entities\ErrorImport;
use Illuminate\Support\Facades\Log;

class ImportsObserver
{
    public function created(ErrorImport $imports)
    {
        Log::notice('The user number '. $imports->created_by.' had been imported '. $imports->count);
    }
}
