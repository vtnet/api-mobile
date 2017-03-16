<?php
  
namespace App\Http\Controllers;
  
use Validator;
use App\Http\Controllers\Controller;
use App\Http\Model\MobileRequestModel;
use Illuminate\Http\Request;

  
  
class MobileRequest extends Controller{
  
 	public function index(){
  
        $Books  = MobileRequestModel::all();
  
        return response()->json($Books);
  
    }
  
    public function getBook($id){
  
        $Book  = MobileRequest::find($id);
  
        return response()->json($Book);
    }
  
    public function create(Request $request){

        if ($request->isJson())
        {
            $arr =  $request->all();

        	$retorno=array();
        	for($i=0,$C=count($arr); $i<$C; $i++){

        		if($this->validateDate($arr[$i]['data_inicio'])){
        			MobileRequestModel::create(
    	    		['data_inicio'=>$arr[$i]['data_inicio'],
    	    		'data_fim'=>$arr[$i]['data_fim'],
    	    		'origem'=>$arr[$i]['origem'],
    	    		'destino'=>$arr[$i]['destino'],
    	    		'localizacao'=>$arr[$i]['localizacao']
    	    		]);
        			$retorno['sucess'][]=$arr[$i];
        		}else{
        			$retorno['erro'][]=$arr[$i];
        		}
        	}

            return response()->json($retorno);
        }else{
            $content = $request->header('content-type');
            $retorno['error']['code']=203;
            $retorno['error']['description'] ='O "Content-Type" HTTP “'.$content.'” não é suportado. Falha no carregamento da mídia';


            return response()->json([$retorno], 203);
        }
  
    }

    function validateDate($date, $format = 'Y-m-d H:i:s')
	{
	    $d = \DateTime::createFromFormat($format, $date);
	    return $d && $d->format($format) == $date;
	}
  
    public function deleteBook($id){
        $Book  = Book::find($id);
        $Book->delete();
 
        return response()->json('deleted');
    }
  
    public function updateBook(Request $request,$id){
        $Book  = Book::find($id);
        $Book->title = $request->input('title');
        $Book->author = $request->input('author');
        $Book->isbn = $request->input('isbn');
        $Book->save();
  
        return response()->json($Book);
    }
 
}