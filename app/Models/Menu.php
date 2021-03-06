<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
* Model for the M Health
*/
class Menu extends Model
{
	protected $table = 'mhealth_menus';
	
	public function scopeMenu($query,$level)
	{
		return $query->where('level',(int) $level)->get();
	}
}