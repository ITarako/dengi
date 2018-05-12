<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\OperationSearchModel */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Operations';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="operation-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Operation', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Upload Operations', ['upload'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            'value',
            [
                'attribute' => 'Currency',
                'value' => function($operation) {
                    return $operation->currency ? $operation->currency->code : null;
                }
            ],
            'operation_date',
            [
                'attribute' => 'Category',
                'value' => function($operation) {
                    return $operation->category ? $operation->category->title : null;
                }
            ],
            [
                'attribute' => 'Account',
                'value' => function($operation) {
                    return $operation->account ? $operation->account->title : null;
                }
            ],
            [
                'attribute' => 'User',
                'value' => function($operation) {
                    return $operation->user ? $operation->user->username : null;
                }
            ],


            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
