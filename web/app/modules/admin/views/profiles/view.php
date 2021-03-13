<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ProfileBase */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Profile Bases', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="profile-base-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'firstname',
            'secondname',
            'lastname',
            'phone',
            'birthdate',
            'passport_series',
            'passport_number',
            'passport_giver',
            'passport_date',
            'registration_address',
            'license_series',
            'license_number',
            'license_date',
            'license_expire',
            'uuid',
            'created_at',
            'updated_at',
            'user_id',
        ],
    ]) ?>

</div>
