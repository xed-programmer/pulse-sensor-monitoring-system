<?php

namespace App\Jobs;

use App\Mail\QueuePulseReportEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class PulseReportSendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $details = null;
    public function __construct($details)
    {
        $this->details = $details;
    }

    public function handle()
    {
        Mail::to($this->details->user->email)
        ->send(new QueuePulseReportEmail($this->details));
    }
}
