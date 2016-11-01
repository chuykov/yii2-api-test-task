<?php
namespace app\api\modules\v1\models;
class Quote extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'authors_quotes';
    }

}