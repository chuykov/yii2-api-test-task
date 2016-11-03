<?php
use Codeception\Util\HttpCode;
$I = new FunctionalTester($scenario);

$I->wantTo('test successful/failed user login');

$I->haveHttpHeader('Content-Type', 'application/json');
$I->sendPOST('/login', '{"email": "alexey-new@plumflowerinternational.com","password": "lkJlkn8hj"}');
$I->seeResponseIsJson();
$I->seeResponseCodeIs(HttpCode::OK);
$I->seeResponseMatchesJsonType([
    'success' => 'boolean',
    'data' => ['token'=>'string'],
]);

$I->haveHttpHeader('Content-Type', 'application/json');
$I->sendPOST('/login', '{"email": "alexey-new@failed.com","password": "lkJlkn8hj"}');
$I->seeResponseIsJson();
$I->seeResponseCodeIs(HttpCode::OK);
$I->seeResponseContainsJson(['success' => false, 'data'=>['message'=>'Email not exists']]);
