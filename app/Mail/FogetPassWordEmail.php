<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class FogetPassWordEmail extends Mailable
{
    use Queueable, SerializesModels;
    private $emailKhachHang;
    private $code;
    /**
     * Create a new message instance.
     */
    public function __construct($emailKhachHang,$code)
    {
        //
        $this->$emailKhachHang = $emailKhachHang;
        $this->code = $code;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Foget Pass Word Email',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'view.name',
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
    public function build(){
        return $this->from('sangntps40437@gmail.com')
        ->to($this->emailKhachHang)
        ->subject('Mẫ Đặt Lại Mật Khẩu')
        ->html('Mã đặt lại mật khẩu của bạn là: '.$this->code);
    }
}
