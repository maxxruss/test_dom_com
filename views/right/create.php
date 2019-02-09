<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Right */

$this->title = 'Create Right';
$this->params['breadcrumbs'][] = ['label' => 'Right', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rights-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
