<?php namespace App\Http\Controllers;

use App\Models\OriginalCOS;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Tigo\MiddleWare\Services\SetCosService;
use App\Tigo\MiddleWare\Services\GetCosInformationService;

use Illuminate\Http\Request;

class OptInOptOutController extends Controller {

	protected $request ;
	private   $cosoptions 	= 	[1 => 'Comverse_test',2 => 'Comverse_test2'];
	protected $logfile = '/logs/ussd_optInOut.log';
	protected $originalCos;

	function __construct(Request $request,OriginalCOS $originalCos) 
	{
		$this->request 		= 	$request;
		$this->originalCos 	= 	$originalCos;
		$this->menu    		=	$this->getMainMenu();

	}

	/**
	 * Method to handle the Package usage
	 */
	public function index()
	{
		// 1. Get the ussd Request 				==> 	DONE
		// 2. Check which level 				==>		DONE
		// 3. Update the level in the session 	==> 	
		// 4. Act as per level and choice made 	==> 	
		// 5. Push USSD to the handset
		
	// is this the first attempt ?
     if($input=$this->request->has('input') && $this->request->has('msisdn') && $this->request->has('session'))
     {
     	$msisdn 	= 	$this->request->get('msisdn');
     	$session 	= 	$this->request->get('session');
     	$input = (int) $this->request->get('input');

     	// Validate MSISDN 
		if(!(strlen($msisdn) == 12) || !(substr($msisdn, 0,5)=='25072'))
		{
			$this->menu = 'Invalid MSISDN.';
			 // Log the response menu
		   	 $this->log('Response menu: '.$this->menu);
		   	 // Push menu to the device
		   	return $this->ussdResponse($this->menu,'FB'); 
		}

       	switch ($input) {
     		case ($input >0 && $input < 3):
     			# We are looking for hospitals
     			$this->menu 	= 	$this->migrateCOS($msisdn,$input,$session);

     			$this->Freeflow = 	'FB';
     			break;
     		default:

     			#Something went wrong
     			$this->menu 	= 	'Oops! we could not understand your request';
     			$this->Freeflow = 	'FB';
     			break;
     	}
     	
     }
   	 // First log input
   	 $this->log($this->request->all());
   	 // Log the response menu
   	 $this->log('Response menu: '.$this->menu);
   	 // Push menu to the device
   	return $this->ussdResponse($this->menu,$this->Freeflow);  

	}

	/**
	 * Get the main menu 
	 */
	private function getMainMenu()
	{
		$menu 	=	"OPT IN OPT OUT \n";
		$menu 	.=	"______________\n";
		$menu 	.=	"1. Opt In\n";
		$menu 	.=	"2. Opt Out\n";

		return $menu;
	}

	/**
	 * Migrate COS of a subscriber
	 */ 
	private function migrateCOS($msisdn,$input,$session)
	{
		$this->log('message : '.'Asked to change the cos of a subscriber');

		//  Backup current Cos
		if($this->backupCos($msisdn,$input,$session))
		{   
			// if subscriber cos is well saved
			// Attempt to change the COS
			$newCos 	=	'Comverse_test';
			
			if($this->setCOS($msisdn,$newCos))
			{
				return $this->menu = 'You got your promotion';
			}

			// Something went wrong
			return $this->menu = 'Something went wrong while giving you the package';	
		}
		
		return $this->menu = 'Could not get your current COS';		
	}

	/**
	 * Keep original COS
	 */ 
	private function backupCos($msisdn,$input,$session)
	{
		$this->log('message : '.' Start to backup the current COS...');

	    // Get the actual COS
		$originalCos = (new GetCosInformationService)->getCos($msisdn)->COSName;
		
		// Save COS and return the status
	    return (new $this->originalCos)->insert($originalCos,$msisdn,$input,$session); 
	}

	/**
	 * Set new COS
	 * 250728413399
	 * 250728487656
	 */ 
	public function setCOS($msisdn,$cos)
	{
		$this->log('message : '.'Trying to  set a new cos...');

		return (new SetCosService)->setCos($msisdn,$cos);
	}
}
