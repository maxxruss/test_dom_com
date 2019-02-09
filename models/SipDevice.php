<?php

namespace app\models;

use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "sip_device".
 *
 * @property int $id
 * @property string $type_device
 * @property int $user_id
 */
class SipDevice extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sip_device';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type_device', 'user_id'], 'required'],
            [['user_id'], 'integer'],
            [['type_device'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type_device' => 'Type Device',
            'user_id' => 'User ID',
        ];
    }

    /**
    @return ActiveQuery
     */
    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id'=>'user_id']);
    }
}
