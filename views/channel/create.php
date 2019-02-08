<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Channel */

$this->title = 'Create Channel';
$this->params['breadcrumbs'][] = ['label' => 'Channel', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="channels-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
