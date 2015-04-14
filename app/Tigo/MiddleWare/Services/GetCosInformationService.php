<?php namespace App\Tigo\MiddleWare\Services;

use DOMDocument;
use App\Tigo\MiddleWare\MiddleWareRequest;

class GetCosInformationService extends  MiddleWareRequest
{
	public $msisdn;

	public function getCos($msisdn)
	{
       $this->url       = env('URL_GET_COS');

		 $this->msisdn 	= $msisdn;

		 return $this->cleanResponse($this->request());
	}
	/**
	 * Get the request for to send to MW
	 */
	public function getRequest()
	{

	$request='<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:v1="http://xmlns.tigo.com/GetBalanceInfoRequest/V1" xmlns:v3="http://xmlns.tigo.com/RequestHeader/V3" xmlns:v2="http://xmlns.tigo.com/ParameterType/V2" xmlns:cor1="http://soa.mic.co.af/coredata_1">
   <soapenv:Header xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
      <cor1:debugFlag>true</cor1:debugFlag>
      <wsse:Security>
         <wsse:UsernameToken>
           <wsse:Username>'.env('MW_USERNAME').'</wsse:Username>
           <wsse:Password>'.env('MW_PASSWORD').'</wsse:Password>
         </wsse:UsernameToken>
      </wsse:Security>
   </soapenv:Header>
   <soapenv:Body>
      <v1:GetBalanceInfoRequest>
         <v3:RequestHeader>
            <v3:GeneralConsumerInformation>
               <v3:consumerID>TIGO</v3:consumerID>
               <!--Optional:-->
               <v3:transactionID>4587</v3:transactionID>
               <v3:country>RWA</v3:country>
               <v3:correlationID>thbs</v3:correlationID>
            </v3:GeneralConsumerInformation>
         </v3:RequestHeader>
         <v1:requestBody>
            <v1:msisdn>'.$this->msisdn.'</v1:msisdn>
            <!--Optional:-->
            <v1:additionalParameters>
               <!--1 or more repetitions:-->
               <v2:ParameterType>
                  <v2:parameterName>consumerType</v2:parameterName>
                  <v2:parameterValue>PREPAID</v2:parameterValue>
               </v2:ParameterType>
            </v1:additionalParameters>
         </v1:requestBody>
      </v1:GetBalanceInfoRequest>
   </soapenv:Body>
</soapenv:Envelope>';

	return $request;
	}

	/**
	 * Clean the xml response
	 */
	public function cleanResponse($soapXMLResult)
	{

		$response = [];

		$doc = new DOMDocument();
		$doc->loadXML( $soapXMLResult );
		
		$response['COSName']    = $doc->getElementsByTagName("parameterValue")->item(0)->nodeValue;

	 return (object) $response;		
	}
}