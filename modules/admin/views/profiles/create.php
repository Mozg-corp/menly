<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ProfileBase */

$this->title = 'Create Profile Base';
$this->params['breadcrumbs'][] = ['label' => 'Profile Bases', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="profile-base-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
