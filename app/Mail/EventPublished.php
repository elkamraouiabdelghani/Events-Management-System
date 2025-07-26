<?php

namespace App\Mail;

use App\Models\Event;
use App\Models\Organizer;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EventPublished extends Mailable
{
    use Queueable, SerializesModels;

    public $event;
    public $organizer;

    /**
     * Create a new message instance.
     */
    public function __construct(Event $event, Organizer $organizer)
    {
        $this->event = $event;
        $this->organizer = $organizer;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Votre événement a été publié avec succès')
            ->view('emails.event_published');
    }
} 