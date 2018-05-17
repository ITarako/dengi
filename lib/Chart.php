<?php

namespace app\lib;


class Chart
{
    public $data = [
        'labels' => [],
        'datasets'=> [],
    ];

    public function __construct(array $operationsByAccount){
        $this->data['labels'] = array_keys(current($operationsByAccount));

        foreach($operationsByAccount as $account => $operation){
            $this->data['datasets'][] = static::createDatasetFromOperation($account, $operation);
        }
    }

    static public function createDatasetFromOperation(string $account, array $operation) :array
    {
        [$r, $g, $b] = static::generateRGB();
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

    static public function generateRGB() :array
    {
        $r = rand(0,255);
        $g = rand(0,255);
        $b = rand(0,255);
        return [$r, $g, $b];
    }
}