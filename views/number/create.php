<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Number */

$this->title = 'Create Number';
$this->params['breadcrumbs'][] = ['label' => 'Number', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="numbers-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
