<?php

namespace app\models;

use yii\db\ActiveQuery;
use yii;
use yii\db\ActiveRecord;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $position
 * @property string $password
 * @property string $authKey
 * @property integer $accessToken
 * @property integer $password_hash
 * @property User[] $user
 */
class User extends ActiveRecord implements \yii\web\IdentityInterface
{


    public static function tableName()
    {
        return 'user';
    }

    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            [['position'], 'string', 'max' => 20],
            ['username', 'unique', 'targetClass' => User::className(),  'message' => 'Этот логин уже занят'],
        ];
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        if ($insert) {
            $userRole = Yii::$app->authManager->getRole($this->position);
            Yii::$app->authManager->assign($userRole, $this->id);
        } else {
            Yii::$app->authManager->revokeAll($this->id);
            $userRole = Yii::$app->authManager->getRole($this->position);
            Yii::$app->authManager->assign($userRole, $this->id);
        }
    }


    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {

        return static::findOne(['accessToken' => $token]);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {

        return static::findOne(['username' => $username]);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     * @throws yii\base\Exception
     */
    public function setPassword($password)
    {
        $this->password = Yii::$app->security->generatePasswordHash($password);
    }


    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->authKey = Yii::$app->security->generateRandomString();
    }

    /**
    @return ActiveQuery
     */
    public function getSipDevice(): ActiveQuery
    {
        return $this->hasMany(SipDevice::class, ['user_id'=>'id']);
    }


    /**
    @return ActiveQuery
     */
    public function getAuthAssignment(): ActiveQuery
    {
        return $this->hasOne(AuthAssignment::class, ['user_id'=>'id']);
    }
}
