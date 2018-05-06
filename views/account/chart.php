<?php
use dosamigos\chartjs\ChartJs;

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

echo ChartJs::widget([
    'type' => 'line',
    'options' => [
        'height' => 200,
        'width' => 300
    ],
    'data' => $data
]);