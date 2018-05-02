<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use \kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Operation */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="operation-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput() ?>

    <?= $form->field($model, 'value')->textInput() ?>

    <?= $form->field($model, 'id_account')->dropDownList($accounts, ['prompt'=>'Выберите счет']) ?>

    <?= $form->field($model, 'id_category')->dropDownList($categories, ['prompt'=>'Выберите категорию']) ?>

    <?= $form->field($model, 'operation_date')->widget(DatePicker::classname(),[
        'options' => ['placeholder' => 'Введите дату операции'],
        'pluginOptions' => [
            'autoclose'=>true,
        ]
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
