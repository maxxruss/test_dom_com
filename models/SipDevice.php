<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sip_device".
 *
 * @property int $id
 * @property string $type_device
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
            [['type_device'], 'required'],
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
        ];
    }
}
