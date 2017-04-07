<?php

namespace App\Http\Controllers;

use App\Http\Controllers\LocationController;
use App\Http\Model\CidadesModel;
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

        $LocationController = new LocationController;
        // // Iniciamos o "contador"
        // list($usec, $sec) = explode(' ', microtime());
        // $script_start = (float) $sec + (float) $usec;


        if(isset($arr['ligacoes'])){
            $ligacoes = $arr['ligacoes'];

            for($i=0,$C=count($ligacoes); $i<$C; $i++){

                if((isset($ligacoes[$i]['data'])) && (isset($ligacoes[$i]['qtd'])) && (isset($ligacoes[$i]['destino'])))    
                {

                    if($this->validateDate($ligacoes[$i]['data'])){


                       /**
                        * Tratamento numero destino
                        */
                        $len = strlen($ligacoes[$i]['destino']);
                        $num = intval($ligacoes[$i]['destino']);
                        switch ($len) {
                            //Local
                            case 8:
                            case 9:
                                break;

                            case 10:
                            case 11:
                                // DDD
                                
                                preg_match('/^([0-9]{2})/', $num, $matches);
                                break;
                            
                            case 12:
                            case 13:
                                // 21DDD
                             
                                preg_match('/^[0-9]{2}([0-9]{2})/', $num, $matches);
                                break;

                            default:
                                
                                break;
                        }

                        $destinoDDD = $matches[1];



                        /**
                         * Minha localização com o google
                         */
                        $Localiza = $LocationController->getLocation(trim($ligacoes[$i]['localizacao']));

                        if($Localiza){

                            $usersLocaliza = DB::table('cidades')
                            ->join('estados', 'estados.id', '=', 'cidades.estado_id')
                            ->where('cidades.cidade', '=', $Localiza['city'])
                            ->where('estados.prefix', '=', $Localiza['province'])
                            ->first();

                            if($usersLocaliza->ddd == intval($destinoDDD)){
                                $tipo = 'local';
                            }else{
                                $tipo = 'ld';
                            }

                            $montante[]=['datatime'=>$ligacoes[$i]['data'],'qtd'=>$ligacoes[$i]['qtd'],'destino'=>$ligacoes[$i]['destino'],'telefones_id'=> $id_telefone,'tipo'=>$tipo];
                        }
                    }else{
                        // return response()->json(['bosta'=>'f']);
                    }
                  
                }
             }

            if(isset($montante)) DB::table('ligacoes')->insert($montante);
                

   
            //  // Terminamos o "contador" e exibimos
            // list($usec, $sec) = explode(' ', microtime());
            // $script_end = (float) $sec + (float) $usec;
            // $elapsed_time = round($script_end - $script_start, 5);
            // echo 'Elapsed time: ', $elapsed_time, ' secs. Memory usage: ', round(((memory_get_peak_usage() / 1024) / 1024), 2), 'Mb';
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
