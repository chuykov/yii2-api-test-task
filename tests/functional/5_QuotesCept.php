<?php
use Codeception\Util\HttpCode;

$I = new FunctionalTester($scenario);
$I->wantTo('test successful/failed quote');

$I->haveHttpHeader('Content-Type', 'application/json');
$I->sendPOST('/login', '{"email": "alexey-new@plumflowerinternational.com","password": "lkJlkn8hj"}');
$I->seeResponseIsJson();
$I->seeResponseCodeIs(HttpCode::OK);
$I->seeResponseMatchesJsonType([
    'success' => 'boolean',
    'data' => ['token'=>'string'],
]);
$token = $I->grabDataFromResponseByJsonPath('$.data.token')[0];


$I->sendGET('/quote');
$I->seeResponseIsJson();
$I->seeResponseCodeIs(HttpCode::OK);
$I->seeResponseContainsJson(['success' => false, 'data'=>['message'=>'Your request was made with invalid credentials.']]);

$I->sendGET('/quote?token='.$token);
$I->seeResponseIsJson();
$I->seeResponseCodeIs(HttpCode::OK);
$I->seeResponseContainsJson(['success' => true]);
