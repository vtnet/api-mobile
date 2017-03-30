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

   
  

    public function post(Request $request){
        $telefones_id=($request->User)->id;
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