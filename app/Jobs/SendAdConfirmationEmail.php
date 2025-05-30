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

    public function __construct(Ad $ad)
    {
        $this->ad = $ad;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
  
           try {
        $this->ad->load('user');
               if (!$this->ad->user) {
            Log::error('Ad user is null in Job', ['ad_id' => $this->ad->id]);
            return;
        }

        Log::info('Sending email to: ' . $this->ad->user->email);
        Mail::to($this->ad->user->email)
            ->send(new AdConfirmationMail($this->ad));
    } catch (\Exception $e) {
        Log::error('Error in SendAdConfirmationEmail Job: '.$e->getMessage(), [
            'trace' => $e->getTraceAsString(),
            'ad_id' => $this->ad->id,
        ]);
        throw $e;
    }
}
}