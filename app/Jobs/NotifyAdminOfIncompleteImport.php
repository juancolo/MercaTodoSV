<?php

namespace App\Jobs;

use App\Entities\User;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use App\Mail\ImportErrorsDueValidation;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyAdminOfIncompleteImport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $user;
    private $errors;

    /**
     * Create a new job instance.
     * @param array $errors
     */
    public function __construct($user, array $errors)
    {
        $this->user = $user;
        $this->errors = $errors;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->user)->send(new ImportErrorsDueValidation($this->errors, $this->user));
    }
}
