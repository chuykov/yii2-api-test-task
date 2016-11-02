<?php

namespace app\api\modules\v1\controllers;
use app\api\modules\v1\ApiQueryParamAuth;
use app\api\modules\v1\models\Quote;
use yii\rest\ActiveController;
class QuoteController extends ActiveController
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

    public function actionIndex() {
        return Quote::getRandom()->one();
    }

    protected function verbs()
    {
        return [
            'index' => ['GET']
        ];
    }

    public function actions()
    {
        return [];
    }
}