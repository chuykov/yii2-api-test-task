<?php

namespace app\api\modules\v1;
use yii\filters\auth\QueryParamAuth;

class ApiQueryParamAuth extends QueryParamAuth
{
    public $tokenParam = 'token';
}