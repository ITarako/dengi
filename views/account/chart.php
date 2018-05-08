<?php

use dosamigos\chartjs\ChartJs;
use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = 'Accounts Chart';
$this->params['breadcrumbs'][] = ['label' => 'Accounts', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Chart';

?>
<div class="account-chart">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= ChartJs::widget([
        'type' => 'line',
        'options' => [
            'height' => 200,
            'width' => 300
        ],
        'data' => $data
    ]) ?>

</div>