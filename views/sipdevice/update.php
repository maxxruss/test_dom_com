<?php

use yii\helpers\Html;
use app\objects\ViewModels\SipCreateView;

/* @var $this yii\web\View */
/* @var $model app\models\SipDevice */
/* @var $viewModel SipCreateView */


$this->title = 'Update Sip Device: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Sip Devices', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="sip-device-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'viewModel' => $viewModel,

    ]) ?>

</div>
