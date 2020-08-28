<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ProfileBase */
/* @var $form ActiveForm */
?>
<div class="profile-web-create">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'firstname') ?>
        <?= $form->field($model, 'secondname') ?>
        <?= $form->field($model, 'lastname') ?>
        <?= $form->field($model, 'birthdate') ?>
        <?= $form->field($model, 'passport_date') ?>
        <?= $form->field($model, 'license_date') ?>
        <?= $form->field($model, 'license_expire') ?>
        <?= $form->field($model, 'updatedAt')->hiddenInput() ?>
        <?= $form->field($model, 'phone') ?>
        <?= $form->field($model, 'passport_series') ?>
        <?= $form->field($model, 'license_series') ?>
        <?= $form->field($model, 'passport_number') ?>
        <?= $form->field($model, 'license_number') ?>
        <?= $form->field($model, 'passport_giver') ?>
        <?= $form->field($model, 'registration_address') ?>
		<img src="<?php echo '/profiles/'. $model->uuid . '/' . $model->foto_selfie?>"
        <?= $form->field($model, 'foto_selfie')->fileInput([]) ?>
		<img src="<?php echo '/profiles/'. $model->uuid . '/' . $model->foto_passport_fotopage?>"
        <?= $form->field($model, 'foto_passport_fotopage')->fileInput([]) ?>
		<img src="<?php echo '/profiles/'. $model->uuid . '/' . $model->foto_passport_registrationpage?>"
        <?= $form->field($model, 'foto_passport_registrationpage')->fileInput([]) ?>
		<img src="<?php echo '/profiles/'. $model->uuid . '/' . $model->foto_license_frontview?>"
        <?= $form->field($model, 'foto_license_frontview')->fileInput([]) ?>
		<img src="<?php echo '/profiles/'. $model->uuid . '/' . $model->foto_license_backview?>"
        <?= $form->field($model, 'foto_license_backview')->fileInput([]) ?>
    
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- profile-web-create -->
