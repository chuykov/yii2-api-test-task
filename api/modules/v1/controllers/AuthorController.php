<?php

namespace app\api\modules\v1\controllers;
use app\api\modules\v1\ApiQueryParamAuth;
use app\api\modules\v1\models\Author;
use yii\rest\ActiveController;
class AuthorController extends ActiveController
{

    public $modelClass = 'app\api\modules\v1\models\Author';

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator'] = [
            'class' => ApiQueryParamAuth::className(),
        ];

        return $behaviors;
    }

    public function actionIndex() {
        sleep(3);
        return Author::getRandom()->one();
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