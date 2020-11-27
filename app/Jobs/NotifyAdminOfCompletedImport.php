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

    /**
     * @param $user
     * @param $message
     */
    public function __construct($user, $message)
    {
        $this->user = $user;
        $this->message = $message;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Imports::create([
            'type' => 'ProductStatus import',
            'filePath' => $this->message,
            'created_by' => $this->user->id
        ]);

        $this->user->notify(new ImportReady($this->message));
    }
}
