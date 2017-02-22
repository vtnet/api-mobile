<?php 

namespace App\Http\Model;
  
use Illuminate\Database\Eloquent\Model;
  
class MobileRequestModel extends Model
{
     

    protected $table = 'mobile_request';
    protected $fillable = ['data_inicio','data_fim','origem','destino','localizacao'];
    public $timestamps = false;
     
}