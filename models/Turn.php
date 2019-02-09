<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "turn".
 *
 * @property int $id
 * @property int $turn_number
 */
class Turn extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'turn';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['turn_number'], 'required'],
            [['turn_number'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'turn_number' => 'Turn Number',
        ];
    }
}
