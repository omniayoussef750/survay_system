<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public $otp;
    /**
     * Create a new message instance.
     */
    public function __construct($otp)
    {
        $this->otp = $otp;
    }
   
     public function build()
    {
        $text = "Your OTP code is: {$this->otp}\n\nThis code is valid for 15 minutes.";

        return $this
            ->subject('Welcome to Survey System - Your OTP Code for Verification')
            ->html($text); // <-- THIS forces Laravel to treat it as inline HTML (or plain text if no tags)
    }
}
