<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class EventRunner extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;
    protected $event;
    protected $code;
    
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct( $event, $code )
    {
        $this->event = $event;
        $this->code = $code;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        \Event::fire( new $this->event($this->code) );
    }
}
