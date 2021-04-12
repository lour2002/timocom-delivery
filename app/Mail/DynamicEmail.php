<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DynamicEmail extends Mailable
{
    use Queueable, SerializesModels;

    protected $data;

    /**
     * Create a new message instance.
     *
     * @param $data
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
        $res = $this->view($this->data['template'])
            ->subject($this->data['subject'])
            ->with([
                "message_text" => $this->data["message"],
                "order" => $this->data["order"],
                "from" => json_decode($this->data["order"]->from, true),
                "to" => json_decode($this->data["order"]->to, true),
                "company" => $this->data["company"]
            ]);

        if (isset($this->data['from'])) {
            $res->from($this->data['from']['email'], $this->data['from']['name']);
        }

        return $res;
    }
}
