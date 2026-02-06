<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use App\Models\EventMst;

class IngatkanPeserta extends Mailable
{
    use Queueable, SerializesModels;
    private $data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data; 
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $event = EventMst::find($this->data['idevent']);
        $peserta = User::find($this->data['idpeserta']);
        return $this->subject('Pengingat Jadwal')
        ->from('divya@gmail.com')
        ->view('email/ingatkanpeserta')
        ->with(
         [
            'peserta' => $peserta,
            'event' => $event
         ]);
    }
}
