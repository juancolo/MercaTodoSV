<?php

namespace App\Observers;

use App\Entities\Exports;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ExportsObserver
{
    /**
     * @param Exports $exports
     * @return void
     */
    public function created(Exports $exports): void
    {
        Log::notice('the user '. $exports->created_by. ' has export a '. $exports->type);
    }
}
