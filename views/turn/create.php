<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Turn */

$this->title = 'Create Turn';
$this->params['breadcrumbs'][] = ['label' => 'Turns', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="turn-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
