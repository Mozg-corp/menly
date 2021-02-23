<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel \app\models\searchmodels\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Referrals';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="user-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'options' => ['style' => 'overflow-x:scroll'],
//        'tableOptions' => ['class' => 'table table-striped'],
        'columns' => [
            [
                'attribute' => 'id',
                'label' => 'New Investor ref ID',
                'headerOptions' => ['style' => 'width:20px']
            ],
            [
                'attribute' => 'referral_id',
                'label' => 'New Investor Account',
                'headerOptions' => ['style' => 'width:20px']
            ],
            [
                'attribute' => 'referralEmail',
                'label' => 'Email',
//                'headerOptions' => ['style' => 'width:20px']
            ],
            [
                'label' => 'New investor Name',
                'attribute' => 'referralFullname',
//                'headerOptions' => ['style' => 'width:200px']
            ],
            [
                'label' => 'Registered Time',
                'attribute' => 'created_at',
//                'headerOptions' => ['style' => 'width:200px']
            ],
            [
                'label' => 'Channel',
                'attribute' => 'channel',
//                'headerOptions' => ['style' => 'width:200px']
            ],
            [
                'label' => 'Country',
                'attribute' => 'referral.country',
                'headerOptions' => ['style' => 'width:160px']
            ],
            [
                'attribute' => 'referralInvestment',
                'headerOptions' => ['style' => 'width:100px'],
                'label' => 'Invested amount',
                'format'=>['decimal',2]
            ],
            [
                'attribute' => 'cashBack',
                'headerOptions' => ['style' => 'width:100px'],
                'label' => 'New Investor Cashback',
                'format'=>['decimal',2]
            ],
            [
                'attribute' => 'referrerFullname',
//                'headerOptions' => ['style' => 'width:200px']
                'label' => 'Inviter',
            ],
            [
                'attribute' => 'referrerEmail',
                'label' => 'Email',
//                'headerOptions' => ['style' => 'width:20px']
            ],
            [
                'attribute' => 'user_id',
                'headerOptions' => ['style' => 'width:80px'],
                'label' => 'Inviter Id',
            ],
            [
                'attribute' => 'amount',
                'headerOptions' => ['style' => 'width:120px'],
                'label' => 'Inviter bonus',
                'format'=>['decimal',2]
            ],
            [
                'attribute' => 'totalProfit',
                'headerOptions' => ['style' => 'width:120px'],
                'label' => 'Inviter total ref profit',
                'format'=>['decimal',2]
            ],
            [
                'attribute' => 'daysPast',
                'headerOptions' => ['style' => 'width:120px'],
                'label' => 'Days Past',
            ],
            [
                'attribute' => 'rate',
                'label' => 'Comission rate',
                'headerOptions' => ['style' => 'width:120px'],
                'format'=>['percent', 2]
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}'/*{update}*/
            ],

            //['class' => 'yii\grid\ActionColumn'],
        ]
    ]); ?>


</div>
