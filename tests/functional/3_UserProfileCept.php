<?php
use Codeception\Util\HttpCode;
$I = new FunctionalTester($scenario);
$I->wantTo('test successful/failed profile');

$I->haveHttpHeader('Content-Type', 'application/json');
$I->sendPOST('/login', '{"email": "alexey-new@plumflowerinternational.com","password": "lkJlkn8hj"}');
$I->seeResponseIsJson();
$I->seeResponseCodeIs(HttpCode::OK);
$I->seeResponseMatchesJsonType([
    'success' => 'boolean',
    'data' => ['token'=>'string'],
]);
$token = $I->grabDataFromResponseByJsonPath('$.data.token')[0];

$I->sendGET('/profile');
$I->seeResponseIsJson();
$I->seeResponseCodeIs(HttpCode::OK);
$I->seeResponseContainsJson(['success' => false, 'data'=>['message'=>'Your request was made with invalid credentials.']]);

$I->sendGET('/profile?token='.$token);
$I->seeResponseIsJson();
$I->seeResponseCodeIs(HttpCode::OK);
$I->seeResponseContainsJson(['success' => true]);

//$I->seeResponseContains('{"success":false,"data":{"name":"Unauthorized","message":"","code":0,"status":401,"type":"yii\\web\\UnauthorizedHttpException"}}');