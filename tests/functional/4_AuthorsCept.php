<?php
use Codeception\Util\HttpCode;

$I = new FunctionalTester($scenario);

$I->wantTo('test successful user login');
$I->haveHttpHeader('Content-Type', 'application/json');
$I->sendPOST('/login', '{"email": "alexey-new@plumflowerinternational.com","password": "lkJlkn8hj"}');
$I->seeResponseIsJson();
$I->seeResponseCodeIs(HttpCode::OK);
$I->seeResponseMatchesJsonType([
    'success' => 'boolean',
    'data' => ['token'=>'string'],
]);
$token = $I->grabDataFromResponseByJsonPath('$.data.token')[0];

$I->wantTo('test failed author');
$I->sendGET('/author');
$I->seeResponseIsJson();
$I->seeResponseCodeIs(HttpCode::OK);
$I->seeResponseContainsJson(['success' => false, 'data'=>['message'=>'Your request was made with invalid credentials.']]);

$I->wantTo('get author');
$I->sendGET('/author?token='.$token);
$I->seeResponseIsJson();
$I->seeResponseCodeIs(HttpCode::OK);
$I->seeResponseContainsJson(['success' => true]);
