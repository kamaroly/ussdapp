<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class PackageUsageController extends Controller {

	protected $request ;
	private   $cosoptions 	= 	[1 => 'Comverse_test',2 => 'Comverse_test2'];

	protected $logfile = '/logs/ussd_package_usage.log';

	function __construct(Request $request) 
	{
		$this->request = 	$request;
		$this->menu    =	$this->getMainMenu();

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
     if($this->request->has('input'))
     {
     	$input = (int) $this->request->get('input');

     	switch ($input) {
     		case ($input >0 && $input < 3):
     			# We are looking for hospitals
     			$this->menu 	= 	$this->migrateCOS();
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
		$menu 	=	"PACKAGE USAGE \n";
		$menu 	.=	"______________\n";
		$menu 	.=	"1. Package 1\n";
		$menu 	.=	"2. Package 2\n";

		return $menu;
	}

	/**
	 * Migrate COS of a subscriber
	 */ 
	private function migrateCOS($msisdn,$option)
	{
		$this->log('message : '.'Asked to change the cos of a subscriber');

		// 1. Backup current Cos
		// 2. if subscriber cos is well saved
		if($this->backupCos($msisdn))
		{
			// Attempt to change the COS
			if($this->setCOS($msisdn,$option))
			{
				return $this->menu = 'You got your promotion';
			}
			// Something went wrong
			return $this->menu = 'Something went wrong while giving you the package';	
		}
		
		return $this->menu = 'Could not get your current COS';		
	}

	private function backupCos($msisdn)
	{
		$this->log('message : '.' Start to backup the current COS...');

		// Get the actual COS
		// Save COS and return the status
		
		/**
		 * @todo impliment PackageUsageRepo
		 */
	 return true; //  $this->PackageUsageRepo->saveCos($msisdn,$originalCos);

	}
	/** Get the Class of service for the current subscriber */
	private function getCOS($msisdn)
	{
		$this->log('message : '.' trying to retrieve current subscriber COS');

		// 1. Call API $this->api->getCos()
		// 2. log obtained information
		// Return data
	}

	/** set the class of service */
	private function setCOS()
	{
		$this->log('message : '.' trying to change the COS Of the subscriber');

		//1. 	Call API $this->api->setCos()
		//2.	Log obtained information 
		//3.	return true or false
	}
}
