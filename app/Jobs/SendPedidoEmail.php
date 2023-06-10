<?php

namespace App\Jobs;

use App\Mail\CompraFinalizada;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendPedidoEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $email;
    public $pedido;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email, $pedido){
        $this->email = $email;
        $this->pedido = $pedido;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->email)->send(new CompraFinalizada($this->pedido));
    }
}
