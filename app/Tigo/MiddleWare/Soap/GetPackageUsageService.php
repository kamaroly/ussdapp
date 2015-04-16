<?php namespace App\Tigo\MiddleWare\Soap;

use SoapClient,DOMDocument;

class GetPackageUsageService 
{
	public $msisdn ;
	
	public static $url;

	public static $methodName = 'Get_current_Package_Usage';

	public static $soapClientParameters = [ 'trace'=> 1,	  // enable trace to view what is happening
      										'exceptions' => 0,// disable exceptions
										    'cache_wsdl' => 0 // disable any caching on the wsdl, encase you alter the wsdl server
										   ];
    /**
     * Make a SOAP UI request
     */
    
	public function request($msisdn)
	{
	  self::$url= env('URL_GET_PACKAGE_USAGE');
	  $this->msisdn = $msisdn;
	  // create a connection to the local host mono .NET pull back the wsdl to get the functions names
	  // and also the parameters and return values
	  $client = new SoapClient(self::$url,self::$soapClientParameters);	
	  
	  // Prepare parameters before sending them to the server
	  $parameters = ['msisdn' 			=> $msisdn,
	  				 'SecurityToken'	=> env('GET_PACKAGE_USAGE_SECURITY_TOKEN')
	  				 ];
      try 
      {
      	// get a response from the WSDL zend server function getQuote for the day monday
       $client->Get_current_Package_Usage($parameters);

       return $this->cleanResponse($client->__getLastResponse());
      }
      catch (SoapFault $soapFault)
      { 
      	throw new Exception($soapClient->__getLastResponse()." Error while Processing Request". htmlentities($soapClient->__getLastRequest()));  	
      }  
	}

	/**
	 * Clean the xml response
	 */
	public function cleanResponse($soapXMLResult)
	{

		$response = [];

		$doc = new DOMDocument();
		$doc->loadXML( $soapXMLResult );

		$soapResponse = $doc->getElementsByTagName("Get_current_Package_UsageResponse")->item(0)->nodeValue;
	    
	   	// Empty response ? no active package    	
	    if(!(bool) $soapResponse)
	    {
	    	return 'You have zero active package';
	    }

		// $response['PackageID']    = $doc->getElementsByTagName("PackageID")->item(0)->nodeValue;

		$response['PackageName']    = $doc->getElementsByTagName("PackageName")->item(0)->nodeValue;

		// $response['PackageDescription']    = $doc->getElementsByTagName("PackageDescription")->item(0)->nodeValue;

		$response['Wallets']    = $doc->getElementsByTagName("Wallets")->item(0)->nodeValue;

		$response['Remaining']    = $doc->getElementsByTagName("Ressources")->item(0)->nodeValue;

		// $response['WalletDescription']    = $doc->getElementsByTagName("WalletDescription")->item(0)->nodeValue;

		$response['Usage']    = $response['Remaining'] - $doc->getElementsByTagName("Usage")->item(0)->nodeValue;

		// If wallet is data convert to MB
		if($response['Wallets'] == 'Data')
		{
		   $response['Remaining'] /=pow(1024,2);
		   $response['Remaining']  = round($response['Remaining'], 2);
		   
		   $response['Usage']/=pow(1024,2);
		    $response['Usage']  = round($response['Usage'], 2);
		}
	 return $response;		
	}
}