<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Attachment;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactController extends Mailable
{
    use Queueable, SerializesModels;
    public $email_KhachHang;
    public $subject;
    public $content;

    /**
     * Create a new message instance.
     */
    public function __construct($email_KhachHang,$subject,$content)
    {
        $this->email_KhachHang = $email_KhachHang;
        $this->subject = $subject;
        $this->content = $content;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Contact Controller',
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

                    ->to($this->email_KhachHang)

                    ->subject($this->subject)

                    ->html($this->content);


                    //send 1 file
                    // ->attach(public_path('file.txt'));

                    //send multiple files

    }                // $message->embed(storage_path('app/public/' . $product->image));
}
