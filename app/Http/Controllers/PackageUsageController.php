<?php namespace App\Http\Controllers;

use SimpleXMLElement;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Tigo\MiddleWare\Soap\GetPackageUsageService;

use Illuminate\Http\Request;

class PackageUsageController extends Controller {

	protected $request ;

	private   $cosoptions 	= 	[1 => 'Comverse_test',2 => 'Comverse_test2'];

	protected $logfile = '/logs/ussd_package_usage.log';

	private $service;

	function __construct(Request $request,GetPackageUsageService $service) 
	{
		$this->request = 	$request;
		$this->service =    $service;
	}

	/**
	 * Method to handle the Package usage
	 */
	public function index()
	{

	 // Do we have msisdn in the request?
	
     if(!$this->request->has('msisdn'))
     {	
     	// KILL THE SESSION
		return $this->ussdResponse('Unable to determine what you want','FB');  
     }

     $this->getPackageUsage($this->request->get('msisdn'));     	

	 $this->Freeflow	= 	'FB';
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
		// Validate MSISDN 
		if(!(strlen($msisdn) == 12) || !(substr($msisdn, 0,5)=='25072'))
		{
			return $this->menu = 'Invalid MSISDN.';
		}
		$response = $this->service->request($msisdn);

		// If the subscriber has no active package 
		if(!is_array($response))
		{
			return $this->menu = 'You have no active package';
		}

		$this->menu = "Active Packages\n";
		$this->menu .= "________________\n";

		foreach($response as $key => $value )
		{
			$this->menu 	.= "$key : ".$value. "\n";
		}

		return $this->menu;
	}

	
}
