<?php

namespace app\api\modules\v1\controllers;
use app\api\modules\v1\ApiQueryParamAuth;
use app\api\modules\v1\models\User;
use yii\rest\ActiveController;
class UserController extends ActiveController
{

    public $modelClass = 'app\api\modules\v1\models\User';
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator'] = [
            'class' => ApiQueryParamAuth::className(),
        ];

        return $behaviors;
    }

    public function actionLogout() {
        $user = User::findOne([
            'id' => \Yii::$app->user->id
        ]);
        $user->token = null;
        $user->save();
        return [];
    }

    public function actionProfile() {
        return ["email"=>\Yii::$app->user->identity->email, "info"=>\Yii::$app->user->identity->info];
    }

    protected function verbs()
    {
        return [
            'profile' => ['GET'],
            'logout' => ['DELETE'],
        ];
    }

    public function actions()
    {
        return [];
    }
}