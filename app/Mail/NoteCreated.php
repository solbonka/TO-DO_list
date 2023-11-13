<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Note;

class NoteCreated extends Mailable
{
    use SerializesModels;

    public Note $note;

    public function __construct(Note $note)
    {
        $this->note = $note;
    }

    public function build(): NoteCreated
    {
        return $this->view('note_created')
            ->subject('New Note Created');
    }
}
