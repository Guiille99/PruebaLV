<?php

namespace App\Jobs;

use App\Mail\ContactMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendContactEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $mensaje;
    public $email;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($mensaje, $email){
        $this->mensaje = $mensaje;
        $this->email = $email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to("books2023.info@gmail.com")->send(new ContactMessage($this->mensaje, $this->email));
    }
}
