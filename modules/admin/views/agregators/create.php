<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\AgregatorBase */

$this->title = 'Create Agregator Base';
$this->params['breadcrumbs'][] = ['label' => 'Agregator Bases', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="agregator-base-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
