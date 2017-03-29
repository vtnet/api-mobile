<?php
  
namespace App\Http\Controllers;
  
use App\Http\Controllers\Controller;
use App\Http\Model\LigacoesModel;
use App\Jobs\ProcessaRegistros;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Monolog\Handler\FirePHPHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Validator;
  
class MobileController extends Controller{
  


    public function index(){
// Log::alert('fff');


// $log = new Logger('a');
// $log->pushHandler(new StreamHandler(storage_path('logs/lumen23.log'), Logger::WARNING));

// // add records to the log
// // $log->warning('Foo');
// // $log->error('Bar');
// $log->info('My logger is now ready');

// $logger = new Logger('my_logger');
// // Now add some handlers
// $logger->pushHandler(new StreamHandler(storage_path('logs/lumen23.log'), Logger::DEBUG));
// $logger->pushHandler(new FirePHPHandler());

// // You can now use your logger
// $logger->info('My logger is now ready');


        $array['status']=['code'=>200,'mensagem'=>'Enviado com sucesso'];
        $array['ligacao']['status_proccess']=['status'=>'processamento', 'status_update'=>''];
        $array['ligacao']['local']=['consumo'=>100,'limite'=>500];
        $array['ligacao']['roaming']=['consumo'=>100,'limite'=>500];

        $array['sms']['status_proccess']=['status'=>'processamento', 'status_update'=>''];
        $array['sms']['local']=['consumo'=>100,'limite'=>500];
        $array['sms']['roaming']=['consumo'=>100,'limite'=>500];

        $array['dados']['status_proccess']=['status'=>'processamento', 'status_update'=>''];
        $array['dados']['local']=['consumo'=>100,'limite'=>500];
        $array['dados']['roaming']=['consumo'=>100,'limite'=>500];


        return response()->json($array);
    }


// {
//     "ligacoes": [{
//         "data": "2017-02-15 00:00:00",
//         "qtd": "60",
//         "destino": "11988161442"
//     }, {
//         "data": "2017-02-15 00:00:00",
//         "qtd": "60",
//         "destino": "11988161442"
//     }],
//     "sms": {
//         "data": "2017-02-15 00:00:00",
//         "qtd": "60",
//         "destino": "11988161442"
//     },
//     "dados": {
//         "data": "2017-02-15 00:00:00",
//         "qtd": "60"
//     }
// }
  
    public function create(Request $request){
        $telefones_id=($request->User)->id;
        
        $arr =  $request->all();
    	$retorno=array();

        if(isset($arr['ligacoes'])){
            $ligacoes = $arr['ligacoes'];




            $job = (new ProcessaRegistros('jog'))->delay(60);
            dispatch($job);

            for($i=0,$C=count($ligacoes); $i<$C; $i++){

                if((isset($ligacoes[$i]['data'])) && (isset($ligacoes[$i]['qtd'])) && (isset($ligacoes[$i]['destino']))){
            dd($ligacoes[$i]);

            		if($this->validateDate($ligacoes[$i]['data'])){
                        dd($ligacoes);
            			LigacoesModel::create(
        	    		['datatime'=>$ligacoes[$i]['data'],
        	    		'qtd'=>$ligacoes[$i]['qtd'],
        	    		'destino'=>$ligacoes[$i]['destino'],
        	    		'telefones_id'=> $telefones_id,
        	    		'tipo'=>'local'
        	    		]);
            			// $retorno['success'][]=$arr[$i];
  
                    }else{
                        // return response()->json(['bosta'=>'f']);
                    }
                }
        	}

            return response()->json(['status'=>['code'=>200,'mensagem'=>'Enviado com sucesso']],200);
        }

        if(isset($arr['sms'])){}

        if(isset($arr['dados'])){}

        return response()->json($retorno);

    }

    function validateDate($date, $format = 'Y-m-d H:i:s')
	{
	    $d = \DateTime::createFromFormat($format, $date);
	    return $d && $d->format($format) == $date;
	}




   


  
 //    public function deleteBook($id){
 //        $Book  = Book::find($id);
 //        $Book->delete();
 
 //        return response()->json('deleted');
 //    }
  
 //    public function updateBook(Request $request,$id){
 //        $Book  = Book::find($id);
 //        $Book->title = $request->input('title');
 //        $Book->author = $request->input('author');
 //        $Book->isbn = $request->input('isbn');
 //        $Book->save();
  
 //        return response()->json($Book);
 //    }
 
}