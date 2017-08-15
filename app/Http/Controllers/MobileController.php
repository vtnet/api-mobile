<?php
  
namespace App\Http\Controllers;
  
use App\Http\Controllers\Controller;
use App\Http\Model\LigacoesModel;
use App\Jobs\ProcessaRegistros;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Monolog\Handler\FirePHPHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Validator;
  
class MobileController extends Controller{

    public function tratar_string($texto){
        
        $array1 = array(   "á", "à", "â", "ã", "ä", "é", "è", "ê", "ë", "í", "ì", "î", "ï", "ó", "ò", "ô", "õ", "ö", "ú", "ù", "û", "ü", "ç"
                     , "Á", "À", "Â", "Ã", "Ä", "É", "È", "Ê", "Ë", "Í", "Ì", "Î", "Ï", "Ó", "Ò", "Ô", "Õ", "Ö", "Ú", "Ù", "Û", "Ü", "Ç"
                     , "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o"
                     , "p", "q", "r", "s", "t", "u", "v", "x", "z", "w", "y", "~", "^", "/", "&");
    
        $array2 = array(   "A", "A", "A", "A", "A", "E", "E", "E", "E", "I", "I", "I", "I", "O", "O", "O", "O", "O", "U", "U", "U", "U", "C"
                     , "A", "A", "A", "A", "A", "E", "E", "E", "E", "I", "I", "I", "I", "O", "O", "O", "O", "O", "U", "U", "U", "U", "C" 
                     , "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O"
                     , "P", "Q", "R", "S", "T", "U", "V", "X", "Z", "W", "Y", "", "", "", "");
                     
        return str_replace($array1, $array2, $texto);
        
    } 
  
    public function csv(){
        $row = 0;
        if (($handle = fopen(storage_path('app')."/informacoes-DDD.csv", "r")) !== FALSE) {
            $array=array();
             while (($data = fgetcsv($handle, 0, ";")) !== FALSE) {
                if($row!=0){
                    $num = count($data);
                    $prefix = filter_var($this->tratar_string($data[0]), FILTER_SANITIZE_STRING);
                    $estado = filter_var($this->tratar_string($data[1]), FILTER_SANITIZE_STRING);
                    $cidade = filter_var($this->tratar_string($data[2]), FILTER_SANITIZE_STRING);
                    $ddd = filter_var($this->tratar_string($data[3]), FILTER_SANITIZE_STRING);

                    //Verifica se o estado ja existe no array
                    $estado_id = array_search($estado, $array);
                    if(!$estado_id){
                        $Estado = \App\Http\Model\EstadosModel::firstOrCreate(['estado' => $estado, 'prefix'=>$prefix]);
                        $array[$Estado->id] = $estado;
                        $estado_id = $Estado->id;
                    }

                    $Cidade = \App\Http\Model\CidadesModel::firstOrCreate(['estado_id' => $estado_id, 'cidade'=>$cidade, 'ddd'=>$ddd]);
                }
                $row++;
             }
        }


        // dd($contents);
        return '<hr /><hr />FIM';
    }

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


    /**
     * Simulando retorno
     * @return [type] [description]
     */
    public function indexTeste(){
        $array['status']=['code'=>200,'mensagem'=>'OK'];

        $array['dados']['ciclo'] = '19-07 / 20-07';
        $array['dados']['plano'] = '10000';

        $array['dados']['consumo']['mobile'] = '20000';
        $array['dados']['consumo']['wifi'] = '30000';
        $array['dados']['consumo']['roaming'] = '5000';


        // $array['ligacao']['status_proccess']=['status'=>'processamento', 'status_update'=>''];
        // $array['ligacao']['local']=['consumo'=>100,'limite'=>500];
        // $array['ligacao']['roaming']=['consumo'=>100,'limite'=>500];

        // $array['sms']['status_proccess']=['status'=>'processamento', 'status_update'=>''];
        // $array['sms']['local']=['consumo'=>100,'limite'=>500];
        // $array['sms']['roaming']=['consumo'=>100,'limite'=>500];

        //--------------------------------------------------------------------------

        $array['dados']['apps'][0]['name'] = 'App1';
        $array['dados']['apps'][0]['package'] = 'br.com.android.app1';

        $array['dados']['apps'][0]['trafficRecords'][0]['rx'] = '1';
        $array['dados']['apps'][0]['trafficRecords'][0]['tx'] = '2';
        $array['dados']['apps'][0]['trafficRecords'][0]['type'] = 1;
        $array['dados']['apps'][0]['trafficRecords'][0]['isRoamming'] = false;
        $array['dados']['apps'][0]['trafficRecords'][0]['active'] = false;

        $array['dados']['apps'][0]['trafficRecords'][1]['rx'] = '2';
        $array['dados']['apps'][0]['trafficRecords'][1]['tx'] = '2';
        $array['dados']['apps'][0]['trafficRecords'][1]['type'] = 1;
        $array['dados']['apps'][0]['trafficRecords'][1]['isRoamming'] = true;
        $array['dados']['apps'][0]['trafficRecords'][1]['active'] = false;

        $array['dados']['apps'][0]['trafficRecords'][2]['rx'] = '5';
        $array['dados']['apps'][0]['trafficRecords'][2]['tx'] = '2';
        $array['dados']['apps'][0]['trafficRecords'][2]['type'] = 0;
        $array['dados']['apps'][0]['trafficRecords'][2]['isRoamming'] = false;
        $array['dados']['apps'][0]['trafficRecords'][2]['active'] = false;

        //----------------------------------------------------------------------------

        $array['dados']['apps'][1]['name'] = 'App2';
        $array['dados']['apps'][1]['package'] = 'br.com.android.app2';
        
        $array['dados']['apps'][1]['trafficRecords'][0]['rx'] = '1';
        $array['dados']['apps'][1]['trafficRecords'][0]['tx'] = '2';
        $array['dados']['apps'][1]['trafficRecords'][0]['type'] = 1;
        $array['dados']['apps'][1]['trafficRecords'][0]['isRoamming'] = false;
        $array['dados']['apps'][1]['trafficRecords'][0]['active'] = false;

        // [{
        //     "name": "app1",
        //     "pachage": "br.com.android",
        //     "trafficRecords": [{
        //             "date": "yyyy-MM-dd HH:mm:ss",
        //             "rx": 1,
        //             "tx": 1,
        //             "type": "MOBILE",
        //             "isRoamming": false,
        //             "active": false
        //         },
        //         {
        //             "date": "yyyy-MM-dd HH:mm:ss",
        //             "rx": 1,
        //             "tx": 1,
        //             "type": "MOBILE",
        //             "isRoamming": false,
        //             "active": false
        //         }
        //     ]
        // }]
         
        
        return response()->json($array);
    }
   
     public function postTeste(Request $request){
        $telefones_id=$request->User->id;
        $arr =  json_encode($request->all());

        $fp = fopen(storage_path('logs').'/'.$telefones_id.'.txt', 'a+');
        fwrite($fp, $arr."\n\n");

        return response()->json(['status'=>['code'=>200,'mensagem'=>'Enviado com sucesso']],200);
    }
  

    public function post(Request $request){
        $telefones_id=$request->User->id;
        $arr =  json_encode($request->all());

        // $job = (new ProcessaRegistros($telefones_id, $arr))
        //             ->delay(Carbon::now()->addMinutes(1));
        // dispatch($job);
        // 
        dispatch(new ProcessaRegistros($telefones_id, $arr));

        return response()->json(['status'=>['code'=>200,'mensagem'=>'Enviado com sucesso']],200);
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