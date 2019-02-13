<?php
namespace app\objects\ViewModels;
use app\models\AuthItem;
use app\models\User;
use yii\helpers\ArrayHelper;
use yii\helpers\BaseArrayHelper;

class AuthAssignmentCreateView
{
    /**
     * @return array
     */
    public function getAuthItemOptions()
    {
        $models = AuthItem::find()
            ->where(['type'=>1])
            ->all();
        return ArrayHelper::map($models, 'name', 'name');
    }
    /**
     * @return array
     */
    public function getUserOptions(): array
    {
        $models = User::find()->all();
        return BaseArrayHelper::map($models, 'id', 'username');
    }
}