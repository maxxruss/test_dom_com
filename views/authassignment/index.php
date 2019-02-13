<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\search\AuthAssignmentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Права пользователей';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-assignment-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'label' => 'Пользователь',                 // указываем не id а username свойство зависимой модели User
                'value' => function ($dataProvider) {
                    return !empty($dataProvider->user->username) ? $dataProvider->user->username : '0'; // $data['name'] для массивов, например, при использовании SqlDataProvider.
                },
            ],
//            'user_id',
            'item_name',
            ['class' => 'yii\grid\ActionColumn',
                'visibleButtons' => [
                    'delete' => FALSE,
                ]],

        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
