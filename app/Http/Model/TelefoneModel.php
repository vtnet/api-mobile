<?php 

namespace App\Http\Model;
  
use Illuminate\Database\Eloquent\Model;
  
class TelefoneModel extends Model
{
     

    protected $table = 'telefones';
    protected $fillable = ['numero','nome','token','id_datascan'];
    // public $timestamps = false;
     
}