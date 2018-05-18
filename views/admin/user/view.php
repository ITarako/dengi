<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\rbac\Role;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

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
            'email:email',
            'username',
            'password_hash',
            [
                'label' => 'Status',
                'value' => $model->status ? 'Active' : 'Disable'
            ],
            [
                'label' => 'Role',
                'value' => function($user) {
                    $role = Yii::$app->authManager->getRolesByUser($user->id);
                    $role = array_pop($role);
                    return ($role instanceof Role) ? $role->name : '';
                }
            ],
            'auth_key',
        ],
    ]) ?>

</div>
