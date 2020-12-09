<?php

namespace App\Jobs;

use App\Entities\User;
use App\Entities\Imports;
use Illuminate\Bus\Queueable;
use App\Notifications\ImportReady;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class NotifyAdminOfCompletedImport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var User
     */
    private $user;
    private $message;
    private $count;

    /**
     * NotifyAdminOfCompletedImport constructor.
     * @param $user
     * @param $count
     */
    public function __construct($user, $count)
    {
        $this->user = $user;
        $this->count = $count;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
       $this->user->notify(new ImportReady($this->count, $this->user));
    }
}
