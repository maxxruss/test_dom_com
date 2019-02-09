<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\objects\ViewModels\SipCreateView;


/* @var $this yii\web\View */
/* @var $model app\models\SipDevice */
/* @var $form yii\widgets\ActiveForm */
/* @var $viewModel SipCreateView */

?>

<div class="sip-device-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'type_device')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'user_id')->dropDownList($viewModel->getUserOptions()) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
