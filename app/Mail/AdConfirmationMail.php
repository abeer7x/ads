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
        public $userName;
    public $adTitle;
    public $adDescription;
    public $adPrice;
    /**
     * Create a new message instance.
     */
    public function __construct(Ad $ad)
    {
    if (!$ad->user) {
        Log::error('Ad user missing in Mailable', ['ad_id' => $ad->id]);
    }

    $this->userName = $ad->user->name ?? 'User';
    $this->adTitle = $ad->title ?? 'No Title';
    $this->adDescription = $ad->description ?? 'No Description';
    $this->adPrice = $ad->price ?? 0;
    }

       public function build()
    {
        return $this->markdown('emails.ad.confirmation')        ->with([
            'userName' => $this->userName,
            'adTitle' => $this->adTitle,
            'adDescription' => $this->adDescription,
            'adPrice' => $this->adPrice,  ]);
    }
}
