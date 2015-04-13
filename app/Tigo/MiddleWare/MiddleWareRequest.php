<?php namespace App\Tigo\MiddleWare;

use GuzzleHttp\Client; // A php library that will help us to send requests
use GuzzleHttp\Stream\Stream;
/**
* Send requests to middleware
*/
class MiddleWareRequest
{	
	/**
	 * A php library that will help us to send requests
	 * @var GuzzleHttp\Client
	 */
	protected $request ;

	/**
	 * Xml format request to send to tigo rwanda MiddleWare
	 * @var xml
	 */ 
	protected $requestXml = '';

    /**
     * Url to use when consuming the API
     * @var example:http://10.138.84.227:8002/osb/services/SendNotification_1_0
     */
 	  public $url ='http://10.138.84.227:8002/osb/services/SendNotification_1_0';
	/**
	 * Content type to send in the header of the request
	 * @var
	 */
    public $contentType  ='text/xml; charset=utf-8';

    /**
	 * Method to send the request to MiddleWare
	 * @param $requestXml string that contains the request to submit to mw
	 * 
	 */
	public function request()
	{
		$client = new Client();

		// Prepare the request 
		$request = $client->createRequest('POST', $this->url);

		// Set the request body
		$request->setBody(Stream::factory($this->getRequest()));

		// Send the request
		$response =$client->send($request);
    	
    	// Check if we get response
		if($body = $response->getBody())
		{	
			// Is the response okay ?
			if(strpos(strtolower($body),'ok'))
			{
				return true;
			}

			// Response is not okay
			return false;
		}

		// For us to reach this level it means something has gone wrong.
		return false;
	}

}

