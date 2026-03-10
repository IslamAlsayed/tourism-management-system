<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TestNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject = 'Test Notification Email';
    public $messageText = 'This is a test email from your Laravel app.';

    public function __construct($request = null)
    {
        $this->subject = $request->subject;
        $this->messageText = $request->message;
    }

    public function build()
    {
        return $this->subject($this->subject)->view('emails.test_notification')->with([
            'subject' => $this->subject,
            'messageText' => $this->messageText,
        ]);
    }
}
