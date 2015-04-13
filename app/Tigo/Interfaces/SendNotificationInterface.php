<?php namespace App\Tigo\Interfaces;

interface SendNotificationInterface
{
	public function send($from,$to,$message);
}