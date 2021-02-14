<?php

/* @var $this \yii\web\View */

use yii\bootstrap\ActiveForm;

?>

<div class="row">
    <div class="col-md-6">
        <h2>Регистрация</h2>
        <?php $form = ActiveForm::begin()?>
            <?= $form->field($model, 'username')?>
            <?= $form->field($model, 'email')?>
            <?= $form->field($model, 'password')->passwordInput()?>

        <div class="form-group">
            <button type="submit" class="btn btn-default">Зарегистрироваться</button>
        </div>
        <?php ActiveForm::end()?>
    </div>
</div>
