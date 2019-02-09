<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Turn */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="turn-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'turn_number')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
