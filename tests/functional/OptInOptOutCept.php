<?php 
$I = new FunctionalTester($scenario);

$I->am('Subscriber');
$I->wantTo('To see the main menu for the Opt In/Out ussd');

// Getting the first MENU
$I->amOnPage('/opt');
$I->see('OPT IN OPT OUT');

//Opting in....
$I->wantTo('op in...');
$I->amOnPage('/opt?session=39279237923&input=1&msisdn=250722123127');
$I->see('You got your promotion');



