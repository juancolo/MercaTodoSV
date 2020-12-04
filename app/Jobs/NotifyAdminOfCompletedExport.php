<?php

namespace App\Jobs;

use App\Entities\Exports;
use Illuminate\Bus\Queueable;
use App\Notifications\ExportReady;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyAdminOfCompletedExport implements ShouldQueue
{
    use Dispatchable,
        InteractsWithQueue,
        Queueable,
        SerializesModels;

    private $user;
    private $filePath;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user, $filePath)
    {
        $this->user = $user;
        $this->filePath = $filePath;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        Exports::create([
            'type' => 'ProductStatus export',
            'filePath' => $this->filePath,
            'created_by' => $this->user->id
        ]);

        $this->user->notify(new ExportReady($this->filePath));
    }
}
