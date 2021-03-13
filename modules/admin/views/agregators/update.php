<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\AgregatorBase */

$this->title = 'Update Agregator Base: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Agregator Bases', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="agregator-base-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
