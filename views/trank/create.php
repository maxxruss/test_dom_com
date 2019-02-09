<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Trank */

$this->title = 'Create Trank';
$this->params['breadcrumbs'][] = ['label' => 'Trank', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="trank-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
