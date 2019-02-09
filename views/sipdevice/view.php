<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\objects\ViewModels\SipCreateView;


/* @var $this yii\web\View */
/* @var $model app\models\SipDevice */
/* @var $viewModel SipCreateView */


$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Sip Devices', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="sip-device-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>

        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'type_device',
            [                                                  // указываем не id а username свойство зависимой модели User
                'label' => 'User',
                'value' =>  !empty($model->user->username) ? $model->user->username : '0'
            ],
        ],
    ]) ?>

</div>
