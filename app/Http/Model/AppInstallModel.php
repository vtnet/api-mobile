<?php 

namespace App\Http\Model;
  
use Illuminate\Database\Eloquent\Model;
  
class AppInstallModel extends Model
{
     

    protected $table = 'app_install';
    protected $fillable = ['telefones_id','modelo','id_device','id_onesignal'];
    // public $timestamps = false;
     
}