<?php

use dosamigos\chartjs\ChartJs;
use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = 'Accounts Chart';
$this->params['breadcrumbs'][] = ['label' => 'Accounts', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Chart';


function createDatasetFromOperation($account, $operation){
    list($r, $g, $b) = generateRGB();
    $dataset = [];
    $dataset['label'] = $account;
    $dataset['data'] = array_values($operation);
    $dataset['pointBorderColor'] = "#fff";
    $dataset['pointHoverBackgroundColor'] = "#fff";
    $dataset['borderColor'] = "rgba($r,$g,$b,1)";
    $dataset['pointHoverBorderColor'] = "rgba($r,$g,$b,1)";
    $dataset['pointBackgroundColor'] = "rgba($r,$g,$b,1)";
    $dataset['backgroundColor'] = "rgba($r,$g,$b,0.2)";

    return $dataset;
}

function generateRGB(){
    $r = rand(0,255);
    $g = rand(0,255);
    $b = rand(0,255);
    return [$r, $g, $b];
}

$data = [
        'labels' => [],
        'datasets'=> [],
    ];

$data['labels'] = array_keys(current($operationsByAccount));

foreach($operationsByAccount as $account => $operation){
    $data['datasets'][] = createDatasetFromOperation($account, $operation);
}

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