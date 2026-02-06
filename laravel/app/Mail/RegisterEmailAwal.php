<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegisterEmailAwal extends Mailable
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
        return $this->subject('Pendaftaran Awal')
        ->from($this->data['email'])
        ->view('email/registerawal')
        ->with(
         [
            'nama' => $this->data['nama'],
             'email' => $this->data['email'],
             'namaweb' => $this->data['namaweb'],
             'emailweb' => $this->data['emailweb'],
             'notlp' => $this->data['notlp']
         ]);
    }
}
