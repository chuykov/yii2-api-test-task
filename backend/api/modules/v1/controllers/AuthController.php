<?php

namespace app\api\modules\v1\controllers;
use app\api\modules\v1\models\User;
use yii\rest\ActiveController;
class AuthController extends ActiveController
{
    public $modelClass = 'app\api\modules\v1\models\User';

    public function actionRegister() {
        $user = new User();
        $user->email = \Yii::$app->request->post('email');
        $user->password = \Yii::$app->request->post('password');
        $user->info = \Yii::$app->request->post('info');
        //var_dump(\Yii::$app->request->post()); die;
        if(!$user->save()) {
            \Yii::$app->response->statusCode = 400;
            return $user->getErrors();
        }
        return [];
    }

    public function actionLogin() {

        $user = User::findOne([
            'email' => \Yii::$app->request->post('email')
        ]);
        if($user) {
            if (\Yii::$app->getSecurity()->validatePassword(\Yii::$app->request->post('password'), $user->password_hash)) {
                $user->token = \Yii::$app->getSecurity()->generateRandomString(32);
                $user->save();
                if($user->save())
                    return ["token"=>$user->token];
                else {
                    \Yii::$app->response->statusCode = 400;
                    return $user->getErrors();
                }
            } else {
                \Yii::$app->response->statusCode = 400;
                return ["message"=>'Wrong credentials'];
            }
        }
        else {
            \Yii::$app->response->statusCode = 400;
            return ["message"=>'Email not exists'];
        }

    }

    public function actions()
    {
        return [];
    }

    protected function verbs()
    {
        return [
            'register' => ['POST'],
            'login' => ['POST'],
        ];
    }
}