<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TariffBase */

$this->title = 'Create Tariff Base';
$this->params['breadcrumbs'][] = ['label' => 'Tariff Bases', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tariff-base-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
