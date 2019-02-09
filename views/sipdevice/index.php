<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\SipDeviceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sip Devices';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="sip-device-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Sip Device', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'type_device',
            [
                'label' => 'user',                 // указываем не id а username свойство зависимой модели User
                'value' => function ($data) {
                    return !empty($data->user->username) ? $data->user->username : '0'; // $data['name'] для массивов, например, при использовании SqlDataProvider.
                },

            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
