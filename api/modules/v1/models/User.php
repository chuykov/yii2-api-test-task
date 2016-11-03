<?php
namespace app\api\modules\v1\models;
use yii\helpers\ArrayHelper;
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{

    private $_profile;

    public $password;

    public static function primaryKey()
    {
        return ['id'];
    }

    /** @inheritdoc */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        return ArrayHelper::merge($scenarios, [
            'register' => ['email', 'password'],
            'create'   => ['email', 'password'],
            'update'   => ['email', 'password'],
        ]);
    }


    /** @inheritdoc */
    public function rules()
    {
        return [
            // email rules
            'emailRequired' => ['email', 'required', 'on' => ['register', 'connect', 'create', 'update']],
            'emailPattern'  => ['email', 'email'],
            'emailLength'   => ['email', 'string', 'max' => 255],
            'emailUnique'   => [
                'email',
                'unique',
                'message' => 'This email address has already been taken'
            ],
            'tokenUnique'   => [
                'token',
                'unique',
                'message' => ''
            ],
            'emailTrim'     => ['email', 'trim'],
            // password rules
            'passwordRequired' => ['password', 'required', 'on' => ['register']],
            'passwordLength'   => ['password', 'string', 'min' => 6, 'max' => 72, 'on' => ['register', 'create']],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * Finds an identity by the given token.
     *
     * @param string $token the token to be looked for
     * @return IdentityInterface|null the identity object that matches the given token.
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::find()->innerJoinWith([
            'token' => function ($query) use ($token) {
                $query->onCondition(['token.token' => $token]);
            },
        ])->one();
    }

    /**
     * @return int|string current user ID
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string current user auth key
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @param string $authKey
     * @return boolean if auth key is valid for current user
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /** @inheritdoc */
    public function beforeSave($insert)
    {
        if ($insert) {
            $this->setAttribute('auth_key', \Yii::$app->getSecurity()->generateRandomString());
        }
        if (!empty($this->password)) {
            $this->setAttribute('password_hash', \Yii::$app->getSecurity()->generatePasswordHash($this->password));
        }
        return parent::beforeSave($insert);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getToken()
    {
        return $this->hasOne(Token::className(), ['user_id' => 'id']);
    }

    /**
     * @param Token $profile
     */
    public function setToken(Token $token)
    {
        $this->_profile = $token;
    }

}