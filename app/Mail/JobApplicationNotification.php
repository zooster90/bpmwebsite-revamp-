<?php

namespace App\Mail;

use App\Models\JobApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class JobApplicationNotification extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public JobApplication $application)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Job Application: ' . $this->application->position,
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.careers.notification',
        );
    }

    public function attachments(): array
    {
        $attachments = [];

        if ($this->application->resume_path) {
            $attachments[] = Attachment::fromStorageDisk('public', $this->application->resume_path)
                ->as('Resume_' . str_replace(' ', '_', $this->application->name) . '.' . pathinfo($this->application->resume_path, PATHINFO_EXTENSION));
        }

        return $attachments;
    }
}
