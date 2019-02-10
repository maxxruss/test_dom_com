<?php
namespace app\objects\ViewModels;
use app\models\SipDevice;
use app\models\User;
use yii\helpers\BaseArrayHelper;

class SipCreateView
{
    /**
     * @return array
     */
    public function getSipDeviceOptions(): array
    {
        $models = SipDevice::find()->all();
        return BaseArrayHelper::map($models, 'id', 'type_device');
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