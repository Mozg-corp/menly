<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Subscription */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="subscription-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_users')->textInput() ?>

    <?= $form->field($model, 'id_tariffs')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>