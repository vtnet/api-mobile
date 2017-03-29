<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProcessaRegistros implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    protected $json;

    /**
     * Create a new job instance.
     *
     * @param  Podcast  $podcast
     * @return void
     */
    public function __construct($json)
    {
        $this->json = $json;
    }

    /**
     * Execute the job.
     *
     * @param  AudioProcessor  $processor
     * @return void
     */
    public function handle()
    {


        $a = fopen(storage_path('logs/jorginho.log'),'a+');
        for ($i=0; $i < 1000000; $i++) { 
            fwrite($a, $this->json."\n");
        }
    }
}