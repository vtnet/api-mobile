<?php 

namespace App\Http\Model;
  
use Illuminate\Database\Eloquent\Model;
  
class EstadosModel extends Model
{
     

    protected $table = 'estados';
    protected $fillable = ['estado','prefix'];
    // public $timestamps = false;
  

}