<?php
/**
 * Created by PhpStorm.
 * User: dm
 * Date: 1/11/16
 * Time: 12:35 PM
 */

namespace app\api\modules\v1;
use yii\filters\auth\QueryParamAuth;

class ApiQueryParamAuth extends QueryParamAuth
{
    public $tokenParam = 'token';
}