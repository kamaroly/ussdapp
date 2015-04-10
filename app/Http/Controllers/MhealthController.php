<?php namespace App\Http\Controllers;

use Input;
use App\Http\Requests;
use App\Models\Menu;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class MhealthController extends Controller {

	private $request;

	public function __construct(Request $request)
	{
		$this->request = $request;

		$this->menu    = $this->getMainMenu();

	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

     // is this the first attempt ?
     if($this->request->has('input'))
     {
     	$input = (int) $this->request->get('input');

     	switch ($input) {
     		case 1:
     			# We are looking for hospitals
     			$this->menu 	= 	$this->getNearestHospitals();
     			$this->Freeflow = 	'FB';
     			break;
     		case 2:
				# We are looking for Pharmacies
     			$this->menu 	= 	$this->getNearestPhamarcies();
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

	private function getNearestHospitals()
	{
		$menu 	= "NEAREST HOSPITAL \n";
	 	$menu 	.= "_________________ \n";
		$menu 	.= "1. Hospital 1 \n";
		$menu 	.= "2. Hospital 2 \n";
		$menu 	.= "3. Hospital 3 \n";
		$menu 	.= "4. Hospital 4 \n";
		$menu 	.= "5. Hospital 5 \n";

		return $menu;
	}

private function getNearestPhamarcies()
	{
		$menu 	= "NEAREST PHARMACIES  \n";
	 	$menu 	.= "__________________ \n";
		$menu 	.= "1. Pharmacy 1 \n";
		$menu 	.= "2. Pharmacy 2 \n";
		$menu 	.= "3. Pharmacy 3 \n";
		$menu 	.= "4. Pharmacy 4 \n";
		$menu 	.= "5. Pharmacy 5 \n";

	  return $menu;
	}
	/**
	 * Main menu for the M-Health application
	 */ 
	private function getMainMenu()
	{
		$menu 	= "M-HEALTH \n";
	 	$menu 	.= "________ \n";

	 	$menus = Menu::menu(0);
	 $option = 1;	
	 foreach($menus as $dbmenu)
	 {
	 	$menu 	.= "$option. ".$dbmenu->name." \n";

	 	$option++;
	 }
		

	return $menu;
	}
}
