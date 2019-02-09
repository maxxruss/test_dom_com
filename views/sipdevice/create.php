<?php

use yii\helpers\Html;
use app\objects\ViewModels\SipCreateView;


/* @var $this yii\web\View */
/* @var $model app\models\SipDevice */
/* @var $viewModel SipCreateView */


$this->title = 'Create Sip Device';
$this->params['breadcrumbs'][] = ['label' => 'Sip Devices', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sip-device-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'viewModel' => $viewModel,

    ]) ?>

</div>
