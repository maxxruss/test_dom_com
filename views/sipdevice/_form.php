<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SipDevice */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sip-device-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'type_device')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
