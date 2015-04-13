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

	}

	/**
	 * Method to handle the Package usage
	 */
	public function index()
	{

	// is this the first attempt ?
     if($this->request->has('msisdn'))
     {	


     	$msisdn			=	$this->request->get('msisdn');
		
		$this->menu 	= 	$this->getPackageUsage($msisdn);     	

		$this->Freeflow	= 	'FB';
     }


   	 // First log input
   	 $this->log($this->request->all());
   	 // Log the response menu
   	 $this->log('Response menu: '.$this->menu);
	
   	 // Push menu to the device
   	return $this->ussdResponse($this->menu,$this->Freeflow);  

	}

	/**
	 * Get package usage
	 */ 
	private function getPackageUsage($msisdn)
	{
		$menu = "Current package usage \n";	
		$menu.= "______________________\n";
		$menu.= "Package Name 1: 00\n";
		$menu.= "Package Name 2: 20\n";

		return $menu;
	}
}
