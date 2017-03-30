<?php

namespace App\Jobs;

use App\Http\Controllers\JobsController;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessaRegistros implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    protected $id_telefone;
    protected $registros;

    public function __construct($id_telefone, $registros)
    {
        $this->id_telefone = $id_telefone;
        $this->registros = $registros;
    }
    public function handle(JobsController $JobsController)
    {
        $JobsController->insertConsumo($this->id_telefone, $this->registros); 
    }
}