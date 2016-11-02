<?php
namespace app\api\modules\v1\models;
class Token extends \yii\db\ActiveRecord
{
    public static function primaryKey()
    {
        return ['user_id'];
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'token';
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}