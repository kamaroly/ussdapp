<?php namespace App\Http\Controllers;

use Log;
use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

abstract class Controller extends BaseController {

	use DispatchesCommands, ValidatesRequests;
 	/**
 	 * Log file name 
 	 */
 	protected $logfile ;
 	/**
 	 * USSD menu to push on the device
 	 */
 	protected $menu    = null;
 	 /**
 	 * USSD menu to push on the device
 	 */
 	protected $Freeflow   = 'FC';

 /**
  * Method to respond to the USSD
  * @access  protected
  * @param   $content Menu to push to the device
  * @param   $Freeflow  (pass FC for menu input prompt or FB for showing ussd push only)
  */
  protected function ussdResponse($content,$Freeflow='FC')
  {
  	 return response($content, 200)
	          ->header('Content-Type','UTF-8')
			  ->header('Freeflow',$Freeflow)
			  ->header('charge','N')
			  ->header('amount',0)
			  ->header('Expires',-1)
			  ->header('Pragma','no-cache')
			  ->header('Cache-Control','max-age=0')
			  ->header('Content-Type','UTF-8')
			  ->header('Content-Length',strlen($content));
  }


  public function log($message)
  {
  	// information to log is array then cast to json
  	if(is_array($message))
  	{
  		$message 	= 	json_encode($message);
  	}

	  Log::useDailyFiles(storage_path().$this->logfile);

    Log::info(json_encode($message));
  }
}
