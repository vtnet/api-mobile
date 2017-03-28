<?php
  
namespace App\Http\Controllers;
  
use Validator;
use App\Http\Controllers\Controller;
use App\Http\Model\LigacoesModel;
use Illuminate\Http\Request;

  
  
class MobileController extends Controller{
  
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
        	for($i=0,$C=count($ligacoes); $i<$C; $i++){

                if((isset($ligacoes[$i]['data'])) && (isset($ligacoes[$i]['qtd'])) && (isset($ligacoes[$i]['destino']))){

            		if($this->validateDate($ligacoes[$i]['data'])){

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




    public function index(){
        // $Book  = Book::find($id);
        // $Book->delete();
 
        return response()->json('deleted');
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