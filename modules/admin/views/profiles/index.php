<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\searchmodels\ProfileSearch */
/* @var $dataProvider \kartik\grid\GridView */

$this->title = 'Profile Bases';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="profile-base-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Profile Base', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
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

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
