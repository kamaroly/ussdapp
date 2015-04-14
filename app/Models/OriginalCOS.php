<?php namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;

/**
* Model for the M Health
*/
class OriginalCOS extends Model
{
	
	protected $table = 'opt_subs_original_cos';

	public static function insert($originalCos,$msisdn,$input,$session)
	{
	  $data =['session'	=> 	$session,	
		'cos'		=>	$originalCos,
		'input'		=>	$input,
		'msisdn'	=>	$msisdn
		];		
    return DB::insert("insert into opt_subs_original_cos ([ussd_session_id], [original_cos], [input], [msisdn],[created_at],[updated_at]) values('$session','$originalCos','$input','$msisdn','".date('Y-m-d H:i:s')."','".date('Y-m-d H:i:s')."')");
	}

}