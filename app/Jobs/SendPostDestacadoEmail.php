<?php

namespace App\Jobs;

use App\Mail\PostDestacado;
use App\Models\EmailNewsletter;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendPostDestacadoEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $post;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($post)
    {
        $this->post = $post;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $emails = EmailNewsletter::all('email');
        foreach ($emails as $email) {
            Mail::to($email->email)->send(new PostDestacado($this->post));
        }
    }
}
