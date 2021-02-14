<?php
/* @var $this \yii\web\View */
use yii\bootstrap\ActiveForm;

?>

<div class="row">
    <div class="col-md-6">
        <h2>Авторизация</h2>
        <?php $form = ActiveForm::begin()?>
        <?= $form->field($model, 'phone')?>
        <?= $form->field($model, 'password')->passwordInput()?>

        <div class="form-group">
            <button type="submit" class="btn btn-default">Авторизоваться</button>
        </div>
        <?php ActiveForm::end()?>
    </div>
</div>
