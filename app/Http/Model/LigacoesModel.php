<?php 

namespace App\Http\Model;
  
use Illuminate\Database\Eloquent\Model;
  
class LigacoesModel extends Model
{
     

    protected $table = 'ligacoes';
    protected $fillable = ['telefones_id','datatime','destino','qtd','tipo'];
    // public $timestamps = false;
     
}