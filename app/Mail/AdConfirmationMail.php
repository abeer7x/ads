<?php

namespace App\Mail;

use App\Models\Ad;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class AdConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;


    public Ad $ad;

    /**
     * Create a new message instance.
     */
    public function __construct(Ad $ad)
    {
        $this->ad = $ad;
    }
    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Your Ad Situation')
                    ->markdown('emails.ads.confirmation'
                    )->with([
                    'ad' => $this->ad,
                    'userName' => $this->ad->user->name ?? 'مستخدم',
                ]);
    }
}
