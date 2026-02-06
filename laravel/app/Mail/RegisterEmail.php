<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegisterEmail extends Mailable
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
        return $this->subject('Selamat Datang di BelajarSoal.id')
            ->from($this->data['email'])
            ->view('email/register')
            ->with(
                [
                    'id' => $this->data['id'],
                    'nama' => $this->data['name'],
                    'namaweb' => $this->data['namaweb'],
                    'emailweb' => $this->data['emailweb'],
                    'notlp' => $this->data['notlp'],
                    'password' => $this->data['password'],
                    'email' => $this->data['email'],
                ]
            );
    }
}
