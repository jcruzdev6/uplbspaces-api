<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Log;

class SignupMailable extends Mailable
{
    use Queueable, SerializesModels;

    public User $user;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Welcome to UPLB Spaces!',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        Log::info('VERIFY_URL:'.env('VERIFY_URL'));
        return new Content(
            view: 'mail.signup',
            with: ['email' => $this->user->email,
                   'linkVerify' => env('VERIFY_URL').'?email='.$this->user->email.'&token='.$this->user->verification_token,
                   'imgLogo' => public_path().'/images/email/uplbspaces-logo.png',
                   'imgLaptop' => public_path().'/images/email/laptop.png'],            
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
