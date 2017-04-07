<?php 

namespace App\Http\Model;
  
use Illuminate\Database\Eloquent\Model;
  
class CidadesModel extends Model
{
     

    protected $table = 'cidades';
    protected $fillable = ['estado_id','cidade', 'ddd'];
    // public $timestamps = false;
     


     public function estados()
    {
        return $this->hasMany('App\Http\Model\EstadosModel', 'id', 'estado_id');
    }

}