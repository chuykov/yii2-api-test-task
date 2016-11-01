<?php

namespace app\api\modules\v1\controllers;
use app\api\modules\v1\ApiQueryParamAuth;
use app\api\modules\v1\models\Quote;
use yii\rest\ActiveController;
use yii\db\Expression;
class QuotesController extends ActiveController
{

    public $modelClass = 'app\api\modules\v1\models\Quote';
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator'] = [
            'class' => ApiQueryParamAuth::className(),
        ];

        return $behaviors;
    }

    public function actionAuthor() {
        $query = Quote::find()
            ->orderBy(new Expression('rand()'))
            ->one();
        unset($query['quote']);
        sleep(5);
        return $query;
    }
    public function actionQuote() {
        $query = Quote::find()
            ->orderBy(new Expression('rand()'))
            ->one();
        unset($query['authorName']);
        sleep(5);
        return $query;
    }

    protected function verbs()
    {
        return [
            'author' => ['GET'],
            'quote' => ['GET'],
        ];
    }

    public function actions()
    {
        return [];
    }
}