<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PO_SandsToVendor extends Mailable
{
    use Queueable, SerializesModels;
    public $details;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details)
    {
    		$pdf = $details['pdf'];
        $this->details = $details;
        $this->pdf = base64_encode($pdf);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Laxyo Energy')
                    ->view('rfq.POSendMail')->attachData(base64_decode($this->pdf), "Laxyo Enery Quotation Purchase-Order.pdf", [
				                'mime' => 'application/pdf',
				            ]);
    }
}
