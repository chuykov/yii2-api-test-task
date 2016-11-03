<?php
use Codeception\Util\HttpCode;

$I = new FunctionalTester($scenario);

$I->wantTo('test successful/fail user logout');
$I->haveHttpHeader('Content-Type', 'application/json');
$I->sendPOST('/login', '{"email": "alexey-new@plumflowerinternational.com","password": "lkJlkn8hj"}');
$I->seeResponseIsJson();
$I->seeResponseCodeIs(HttpCode::OK);
$I->seeResponseMatchesJsonType([
    'success' => 'boolean',
    'data' => ['token'=>'string'],
]);
$token = $I->grabDataFromResponseByJsonPath('$.data.token')[0];

$I->sendGET('/profile?token='.$token);
$I->seeResponseIsJson();
$I->seeResponseCodeIs(HttpCode::OK);
$I->seeResponseContainsJson(['success' => true]);

$I->sendDELETE('/logout?token=123');
$I->seeResponseIsJson();
$I->seeResponseCodeIs(HttpCode::OK);
$I->seeResponseContainsJson(['success' => false]);

$I->sendDELETE('/logout?token='.$token);
$I->seeResponseIsJson();
$I->seeResponseCodeIs(HttpCode::OK);
$I->seeResponseContainsJson(['success' => true]);

$I->sendGET('/profile?token='.$token);
$I->seeResponseIsJson();
$I->seeResponseCodeIs(HttpCode::OK);
$I->seeResponseContainsJson(['success' => false]);