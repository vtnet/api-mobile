<?php 

namespace App\Http\Model;
  
use Illuminate\Database\Eloquent\Model;
  
class TelefoneModel extends Model
{
     

    protected $table = 'telefones';
    protected $fillable = ['numero','nome','senha'];
    // public $timestamps = false;
     
}