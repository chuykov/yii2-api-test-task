<?php

namespace app\api\modules\v1\controllers;

use app\api\modules\v1\models\Token;
use app\api\modules\v1\models\User;
use yii\rest\ActiveController;

class AuthController extends ActiveController
{
    public $modelClass = 'app\api\modules\v1\models\User';

    public function actionRegister()
    {
        $user = new User();
        $user->email = \Yii::$app->request->post('email');
        $user->password = \Yii::$app->request->post('password');
        $user->info = \Yii::$app->request->post('info');
        if (!$user->save()) {
            \Yii::$app->response->statusCode = 400;
            return $user->getErrors();
        }
        return [];
    }

    public function actionLogin()
    {

        $user = User::findOne([
            'email' => \Yii::$app->request->post('email')
        ]);
        if ($user) {
            if (\Yii::$app->getSecurity()->validatePassword(\Yii::$app->request->post('password'), $user->password_hash)) {
                $token = $user->getToken()->one();
                if ($token) {
                    $token->token = \Yii::$app->getSecurity()->generateRandomString(32);
                } else {
                    $token = new Token();
                    $token->token = \Yii::$app->getSecurity()->generateRandomString(32);
                    $token->link('user', $user);
                }
                if ($token->save())
                    return ["token" => $token->token];
                else {
                    \Yii::$app->response->statusCode = 400;
                    return $token->getErrors();
                }
            } else {
                \Yii::$app->response->statusCode = 400;
                return ["message" => 'Wrong credentials'];
            }
        } else {
            \Yii::$app->response->statusCode = 400;
            return ["message" => 'Email not exists'];
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