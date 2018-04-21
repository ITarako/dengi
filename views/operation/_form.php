<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Operation */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="operation-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'value')->textInput() ?>

    <?= $form->field($model, 'dt')->textInput() ?>

    <?= $form->field($model, 'id_account')->dropDownList($accounts, ['prompt'=>'Выберите счет']) ?>

    <?= $form->field($model, 'id_category')->dropDownList($categories, ['prompt'=>'Выберите категорию']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
