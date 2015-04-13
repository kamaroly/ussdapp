<?php 
$I = new FunctionalTester($scenario);

$I->am('Subscriber');
$I->wantTo('see package usage');

// Change url
$I->amOnPage('/packageusage?session=39279237923&input=1&msisdn=250722123127');

$I->see('Current package usage');
