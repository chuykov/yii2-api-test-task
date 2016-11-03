<?php
use Codeception\Util\HttpCode;

$I = new FunctionalTester($scenario);
$I->haveFixtures(['\yii\test\InitDbFixture']);

$I->wantTo('test the public page');
$I->sendGET('/info');
$I->seeResponseIsJson();
$I->seeResponseCodeIs(HttpCode::OK);
$I->seeResponseContainsJson(['success' => true, 'data'=>['info'=>'Some information about the <b>company</b>.']]);
