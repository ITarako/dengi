<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Account */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Upload Operations';
$this->params['breadcrumbs'][] = ['label' => 'Operations', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Upload Operations';
?>

<div class="operation-upload">

    <?php $form = ActiveForm::begin([
            'options' => [
                'method' => 'post',
                'enctype' => 'multipart/form-data'
                ]
            ]
        )
    ?>

    <?= $form->field($model, 'operationsFile')->fileInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Upload', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end() ?>

</div>