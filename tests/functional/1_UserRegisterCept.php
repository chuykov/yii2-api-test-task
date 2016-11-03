<?php
use Codeception\Util\HttpCode;

$I = new FunctionalTester($scenario);

$I->wantTo('test successful/failed (existing email) user registration');
$I->haveHttpHeader('Content-Type', 'application/json');
$I->sendPOST('/register', '{"email": "alexey-new@plumflowerinternational.com","password": "lkJlkn8hj","info": "I’m experienced <b>web</b> developer 2!"}');
$I->seeResponseIsJson();
$I->seeResponseCodeIs(HttpCode::OK);
$I->seeResponseContainsJson(['success' => true]);

$I->haveHttpHeader('Content-Type', 'application/json');
$I->sendPOST('/register', '{"email": "alexey-new@plumflowerinternational.com","password": "lkJlkn8hj","info": "I’m experienced <b>web</b> developer 2!"}');
$I->seeResponseIsJson();
$I->seeResponseCodeIs(HttpCode::OK);
$I->seeResponseContainsJson(['success' => false, 'data'=>['email'=>['This email address has already been taken']]]);


//$I->seeResponseContains('{"success":false,"data":{"name":"Unauthorized","message":"","code":0,"status":401,"type":"yii\\web\\UnauthorizedHttpException"}}');