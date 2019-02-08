<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "channel".
 *
 * @property int $id
 * @property string $channel_type
 */
class Channel extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'channel';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['channel_type'], 'required'],
            [['channel_type'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'channel_type' => 'Разговорный канал',
        ];
    }
}
