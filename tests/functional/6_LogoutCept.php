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

$I->wantTo('get profile');
$I->sendGET('/profile?token='.$token);
$I->seeResponseIsJson();
$I->seeResponseCodeIs(HttpCode::OK);
$I->seeResponseContainsJson(['success' => true]);

$I->wantTo('fail logout');
$I->sendDELETE('/logout?token=123');
$I->seeResponseIsJson();
$I->seeResponseCodeIs(HttpCode::OK);
$I->seeResponseContainsJson(['success' => false]);

$I->wantTo('logout');
$I->sendDELETE('/logout?token='.$token);
$I->seeResponseIsJson();
$I->seeResponseCodeIs(HttpCode::OK);
$I->seeResponseContainsJson(['success' => true]);

$I->wantTo('get fail for token');
$I->sendGET('/profile?token='.$token);
$I->seeResponseIsJson();
$I->seeResponseCodeIs(HttpCode::OK);
$I->seeResponseContainsJson(['success' => false]);