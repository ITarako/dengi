<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\rbac\Role;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearchModel */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'email:email',
            'username',
            'password_hash',
            [
                'attribute' => 'Status',
                'value' => function($user) {
                    return ($user->status) ? 'Active' : 'Disable';
                }
            ],
            [
                'attribute' => 'Role',
                'value' => function($user) {
                    $role = Yii::$app->authManager->getRolesByUser($user->id);
                    $role = array_pop($role);
                    return ($role instanceof Role) ? $role->name : '';
                }
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
