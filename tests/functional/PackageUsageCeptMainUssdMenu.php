<?php 
$I = new FunctionalTester($scenario);

$I->am('A ussd gateway');
$I->wantTo('I want to see the main ussd menu');

// Visiting the url
$I->amOnPage('/packageusage');

$I->see('PACKAGE USAGE');

