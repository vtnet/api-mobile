<?php

namespace App\Http\Controllers;

use App\Http\Model\LigacoesModel;
use Illuminate\Support\Facades\DB;

class JobsController extends Controller
{
   

   
    /**
     * Recebe o jobs com todos os registros do mobile (Ligacoes, SMS, Dados)
     * @param  [Integer] $id_empresa [ID do numero mobile]
     * @param  [String] $registros  [Json de todos os reggistros]
     * @return [void]           
     */
    public function insertConsumo($id_telefone, $registros){

        // $a = fopen(storage_path('logs/'.$id_telefone.'job.log'),'a+');
        // fwrite($a, $registros."\n");

        $arr =  json_decode($registros, true);

        // Iniciamos o "contador"
        list($usec, $sec) = explode(' ', microtime());
        $script_start = (float) $sec + (float) $usec;


        if(isset($arr['ligacoes'])){
            $ligacoes = $arr['ligacoes'];

            for($i=0,$C=count($ligacoes); $i<$C; $i++){

                if((isset($ligacoes[$i]['data'])) && (isset($ligacoes[$i]['qtd'])) && (isset($ligacoes[$i]['destino']))){

                 if($this->validateDate($ligacoes[$i]['data'])){

                     LigacoesModel::create(
                     ['datatime'=>$ligacoes[$i]['data'],
                     'qtd'=>$ligacoes[$i]['qtd'],
                     'destino'=>$ligacoes[$i]['destino'],
                     'telefones_id'=> $id_telefone,
                     'tipo'=>'local'
                     ]);
                     // $retorno['success'][]=$arr[$i];
    
                    // DB::insert('insert into ligacoes (datatime, qtd, destino, telefones_id, tipo) values (?, ?, ?, ?, ?)', [
                    //         $ligacoes[$i]['data'],
                    //         $ligacoes[$i]['qtd'],
                    //         $ligacoes[$i]['destino'],
                    //         $id_telefone,
                    //         'local'
                    //         ]);

                    }else{
                        // return response()->json(['bosta'=>'f']);
                    }
                  
                }
         }
   
             // Terminamos o "contador" e exibimos
            list($usec, $sec) = explode(' ', microtime());
            $script_end = (float) $sec + (float) $usec;
            $elapsed_time = round($script_end - $script_start, 5);
            echo 'Elapsed time: ', $elapsed_time, ' secs. Memory usage: ', round(((memory_get_peak_usage(true) / 1024) / 1024), 2), 'Mb';
            // return response()->json(['status'=>['code'=>200,'mensagem'=>'Enviado com sucesso']],200);
        }

        if(isset($arr['sms'])){}

        if(isset($arr['dados'])){}

        // return response()->json($retorno);
    }



    public function validateDate($date, $format = 'Y-m-d H:i:s')
    {
        $d = \DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }
}
