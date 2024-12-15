<?php


namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CampaignMail extends Mailable
{
use Queueable, SerializesModels;

public $subject;
public $message;

/**
* Create a new message instance.
*
* @param string $subject
* @param string $message
*/
public function __construct($subject, $message)
{
$this->subject = $subject;
$this->message = $message;
}

/**
* Build the message.
*
* @return $this
*/
public function build()
{
return $this->subject($this->subject)
->markdown('emails.campaign')
->with(['message' => $this->message]);
}
}