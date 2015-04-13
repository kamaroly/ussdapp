<?php namespace App\Tigo\MiddleWare\Services;

use App\Tigo\MiddleWare\MiddleWareRequest;

use App\Tigo\Interfaces\SendNotificationInterface;

class SendNotification extends MiddleWareRequest implements  SendNotificationInterface
{
	public $url 	= 	'http://10.138.84.227:8002/osb/services/SendNotification_1_0';
	public $from;
	public $to;
	public $message;
	
	public  function send($from,$to,$message)
	{

	  $this->from 		=	$from;
	  $this->to 		= 	$to;
	  $this->message 	= 	$message;

      return $this->request();
	}

	/**
	 * Get the request for to send to MW
	 */
	public function getRequest()
	{

	$request='
			<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:v1="http://xmlns.tigo.com/SendNotificationRequest/V1" xmlns:v3="http://xmlns.tigo.com/RequestHeader/V3" xmlns:v2="http://xmlns.tigo.com/ParameterType/V2" xmlns:cor="http://soa.mic.co.af/coredata_1">
			   <soapenv:Header xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
			      <cor:debugFlag>true</cor:debugFlag>
			      <wsse:Security>
			         <wsse:UsernameToken>
			            <wsse:Username>test_mw_osb</wsse:Username>
			            <wsse:Password>tigo1234</wsse:Password>
			         </wsse:UsernameToken>
			      </wsse:Security>
			   </soapenv:Header>
			   <soapenv:Body>
			      <v1:SendNotificationRequest>
			         <v3:RequestHeader>
			            <v3:GeneralConsumerInformation>
			               <!--Optional:-->
			               <v3:consumerID>TIGO</v3:consumerID>
			               <!--Optional:-->
			               <v3:transactionID>345cyz</v3:transactionID>
			               <v3:country>RWA</v3:country>
			               <v3:correlationID>1234</v3:correlationID>
			            </v3:GeneralConsumerInformation>
			         </v3:RequestHeader>
			         <v1:RequestBody>
			            <v1:channelId>SMS</v1:channelId>
			            <v1:customerId>'.$this->to.'</v1:customerId>
			            <v1:message>'.$this->message.'</v1:message>
			           <!--Optional:-->
			            <v1:additionalParameters>
			               <v2:ParameterType>
			                  <v2:parameterName>smsShortCode</v2:parameterName>
			                  <v2:parameterValue>'.$this->from.'</v2:parameterValue>
			               </v2:ParameterType>
			            </v1:additionalParameters>
			            <!--Optional:-->
			            <v1:reasonCode>110</v1:reasonCode>
			            <v1:externalTransactionId>1234</v1:externalTransactionId>
			            <!--Optional:-->
			            <v1:comment>Send Notification by USSD APP</v1:comment>
			         </v1:RequestBody>
			      </v1:SendNotificationRequest>
			   </soapenv:Body>
			</soapenv:Envelope>';

	return $request;
	}
}