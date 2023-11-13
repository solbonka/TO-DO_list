<?php

namespace App\Jobs;

use App\Mail\NoteCreated;
use App\Models\Note;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendAdminMessageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $note;

    /**
     * Create a new job instance.
     */
    public function __construct($note)
    {
        $this->note = $note;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $admins = User::where('is_admin', true)->pluck('email')->all();

        Mail::to($admins)->send(new NoteCreated($this->note));
    }
}
