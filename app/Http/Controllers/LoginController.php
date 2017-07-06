<?php
  
namespace App\Http\Controllers;
  
use Validator;
use App\Http\Controllers\Controller;
use App\Http\Model\MobileRequestModel;
use App\Http\Model\AppInstallModel;
use App\Http\Model\TelefoneModel;
use Illuminate\Http\Request;


class LoginController extends Controller{
  
    /**
     * [get description]
     * @param  Request $request [Requisição HTTP]
     * @return [json]           [Retorna um json com o token do usuario]
     */
    public function get(Request $request){
  
        // $this->validate($request, [
        //     'numero' => 'required|min:10|max:20',
        //     'senha' => 'required',
        //     // 'modelo' => 'required|min:0',
        //     'id_device' => 'required',
        //     'id_onesignal' => 'required',
        // ]);


        $validator = Validator::make($request->all(), [
            'numero' => 'required|min:10|max:20',
            'senha' => 'required',
            // 'modelo' => 'required|min:0',
            'id_device' => 'required',
            'id_onesignal' => 'required',]);

        if ($validator->fails()) {   
            $errors = $validator->errors();

            
            if ($errors->has('numero')) {
                $err[]= ['tipo'=>'numero', 'msg'=>$errors->first('numero')];
            }

            if ($errors->has('senha')) {
                $err[]= ['tipo'=>'senha', 'msg'=>$errors->first('senha')];
            }

            if ($errors->has('id_device')) {
                $err[]= ['tipo'=>'id_device', 'msg'=>$errors->first('id_device')];
            }

            if ($errors->has('id_onesignal')) {
                $err[]= ['tipo'=>'id_onesignal', 'msg'=>$errors->first('id_onesignal')];
            }

             return response()->json(['result'=>$err], 422);
        }


        $numero = filter_var($request->input('numero'), FILTER_SANITIZE_STRING);
        $senha = filter_var($request->input('senha'), FILTER_SANITIZE_STRING);
        $modelo = filter_var($request->input('modelo'), FILTER_SANITIZE_STRING);
        $id_device = filter_var($request->input('id_device'), FILTER_SANITIZE_STRING);
        $id_onesignal = filter_var($request->input('id_onesignal'), FILTER_SANITIZE_STRING);

        $fields = array(
            't_principal' => 'dfug8df8gdf9fg9d',
            'numero' => urlencode($numero),
            'senha' => urlencode($senha)
        );

        $url = 'http://sistema.setaconsultoria.com.br/api_autenticacao_numero.php';
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json'));
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch,CURLOPT_POST, count($fields));
        curl_setopt($ch,CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
        $output = json_decode(curl_exec($ch), true);
        $info = curl_getinfo($ch);
        $http_result = $info ['http_code'];
        curl_close ($ch);

        switch ($http_result) {
            case '200':
                # code...
                break;
            case '203': // Sem permissao
                return response()->json(['status'=>['code'=>203,'mensagem'=>'Número ou senha inválida']],203);
                // return response()->json(array('error'=>'Numero não autorizado.'),203);
                break;
            
            default:
                return response()->json(['status'=>['code'=>500,'mensagem'=>'Erro interno: Consulta API datascam']],500);
                // return response()->json(array('error'=>'Erro interno: Consulta API datascam'),$http_result);
                break;
        }

        $token = md5($output['id']);
        $logo = 'http://ios.org.br/wp-content/uploads/2015/11/anhanguera_comassinatura.jpg';
        $id_datascan = $output['id'];
        $nome = $output['nome'];

        $rs=TelefoneModel::where('numero', $numero)->first();

        if(!$rs){

            /**
             * Registrar toda vez que o aplicativo for instalado.
             */
            $rs = TelefoneModel::create(
                    ['numero'=>$numero,
                    'nome'=>$nome,
                    'token'=>$token,
                    'id_datascan'=>$id_datascan]);
        }

        AppInstallModel::create(['telefones_id'=>$rs->id,
                    'modelo'=>$modelo,
                    'id_onesignal'=>$id_onesignal,
                    'id_device'=>$id_device]);

        return response()->json(['status'=>['code'=>200,'mensagem'=>'OK'], 'token'=>$token, 'logo'=>$logo]);
        // return response()->json(array('token'=>$token));

    }




      
     //    public function create(Request $request){

     //        if ($request->isJson())
     //        {
 //            $arr =  $request->all();

 //        	$retorno=array();
 //        	for($i=0,$C=count($arr); $i<$C; $i++){

 //        		if($this->validateDate($arr[$i]['data_inicio'])){
 //        			MobileRequestModel::create(
 //    	    		['data_inicio'=>$arr[$i]['data_inicio'],
 //    	    		'data_fim'=>$arr[$i]['data_fim'],
 //    	    		'origem'=>$arr[$i]['origem'],
 //    	    		'destino'=>$arr[$i]['destino'],
 //    	    		'localizacao'=>$arr[$i]['localizacao']
 //    	    		]);
 //        			$retorno['sucess'][]=$arr[$i];
 //        		}else{
 //        			$retorno['erro'][]=$arr[$i];
 //        		}
 //        	}

 //            return response()->json($retorno);
 //        }else{
 //            $content = $request->header('content-type');
 //            $retorno['error']['code']=203;
 //            $retorno['error']['description'] ='O "Content-Type" HTTP “'.$content.'” não é suportado. Falha no carregamento da mídia';

 //            return response()->json([$retorno], 203);
 //        }
  
 //    }

 //    function validateDate($date, $format = 'Y-m-d H:i:s')
	// {
	//     $d = \DateTime::createFromFormat($format, $date);
	//     return $d && $d->format($format) == $date;
	// }
  
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