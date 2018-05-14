<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UploadSearchModel */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Uploads';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="upload-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Upload', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'filename',
            'filesize',
            'extension',
            'path',
            //'uploaded_at',
            //'id_user',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
