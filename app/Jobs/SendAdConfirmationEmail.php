<?php

namespace App\Jobs;

use App\Models\Ad;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdConfirmationMail;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class SendAdConfirmationEmail implements ShouldQueue
{
     use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $ad;

    public function __construct($ad)
    {
        $this->ad = $ad;
    }


    public function handle(): void
    {  
        if (!$this->ad) {
            Log::error("Ad is null in SendAdConfirmationEmail job.");
            return;
        }
        if (!$this->ad->user || !$this->ad->user->email) {
            Log::error("User or email not found for Ad ID {$this->ad->id}");
            return;
        }

        try {
            Mail::to($this->ad->user->email)->queue(new AdConfirmationMail($this->ad));
        } catch (\Exception $e) {
            Log::error('SendAdConfirmationEmail failed: ' . $e->getMessage());
        }
    }
}


