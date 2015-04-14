<?php  namespace App\Tigo\MiddleWare\Services;

use DOMDocument,Log;
use App\Tigo\MiddleWare\MiddleWareRequest;

class SetCosService extends  MiddleWareRequest
{
/**
	 * Overwrite the URL
	 */
	
	public $msisdn;
	public $cos;

	public function setCos($msisdn,$cos)
	{
		 $this->url = env('URL_SET_COS');
		 $this->msisdn 	= $msisdn;
		 $this->cos 	= $cos;

		 return $this->cleanResponse($this->request());
	}
	/**
	 * Get the request for to send to MW
	 */
	public function getRequest()
	{

	$request='<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:v1="http://xmlns.tigo.com/ModifySubscriberRequest/V1" xmlns:v3="http://xmlns.tigo.com/RequestHeader/V3" xmlns:v2="http://xmlns.tigo.com/ParameterType/V2" xmlns:cor="http://soa.mic.co.af/coredata_1">
   <soapenv:Header xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
      <cor:debugFlag>true</cor:debugFlag><wsse:Security>
         <wsse:UsernameToken>
            <wsse:Username>'.env('MW_USERNAME').'</wsse:Username>
   			<wsse:Password>'.env('MW_PASSWORD').'</wsse:Password>
         </wsse:UsernameToken>
      </wsse:Security></soapenv:Header>
   <soapenv:Body>
      <v1:ModifySubscriberRequest>
         <v3:RequestHeader>
            <v3:GeneralConsumerInformation>
               <!--Optional:-->
               <v3:consumerID>TIGO</v3:consumerID>
               <!--Optional:-->
               <v3:transactionID>freer4t</v3:transactionID>
               <v3:country>RWA</v3:country>
               <v3:correlationID>sgrhfh</v3:correlationID>
            </v3:GeneralConsumerInformation>
         </v3:RequestHeader>
         <v1:RequestBody>
            <v1:msisdn>'.$this->msisdn.'</v1:msisdn>
            <!--Optional:-->
            <v1:additionalParameters>
               <!--1 or more repetitions:-->
               <v2:ParameterType>
                  <v2:parameterName>ConsumerType</v2:parameterName>
                  <v2:parameterValue>Prepaid</v2:parameterValue>
               </v2:ParameterType>
               <v2:ParameterType>
                  <v2:parameterName>COSName</v2:parameterName>
                  <v2:parameterValue>'.$this->cos.'</v2:parameterValue>
               </v2:ParameterType>
            </v1:additionalParameters>
         </v1:RequestBody>
      </v1:ModifySubscriberRequest>
   </soapenv:Body>
</soapenv:Envelope>';

	return $request;
	}

	/**
	 * Clean the xml response
	 */
	public function cleanResponse($soapXMLResult)
	{
		
		$doc = new DOMDocument();
		
		$doc->loadXML( $soapXMLResult );
		
		$status = $doc->getElementsByTagName("status")->item(0)->nodeValue;

		return (strtolower($status) == 'ok');
	}
}