<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\lib\Utils;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */

$role = Utils::getRoleById($model->id);
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'email')->textInput() ?>

    <?= $form->field($model, 'username')->textInput() ?>

    <?= $form->field($model, 'status')->radioList([ 0 => 'Disable', 1 => 'Active']) ?>

    <div class="form-group">
        <?= Html::label('Role', 'role', ['class'=>'control-label']) ?>
        <?= Html::radioList('role', [$role], ['user' => 'User', 'admin'=>'Admin']) ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
