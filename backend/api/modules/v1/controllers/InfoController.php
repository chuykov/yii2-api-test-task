<?php

namespace app\api\modules\v1\controllers;
use yii\rest\ActiveController;
class InfoController extends ActiveController
{

    public $modelClass = 'app\api\modules\v1\models\User';

    public function actionIndex() {
        return ["info"=>"Some information about the <b>company</b>."];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionError()
    {
        $exception = Yii::$app->errorHandler->exception;
        if ($exception !== null) {
            return $this->render('error', ['exception' => $exception]);
        }
    }

    protected function verbs()
    {
        return [
            'index' => ['GET', 'HEAD'],
        ];
    }
}