<?php

namespace app\lib;

class OperationsGenerator
{
    private $account_title;
    private $operations = [
        ['slug' => 'car-service', 'title' => 'Масло'],
        ['slug' => 'car-service', 'title' => 'Колеса'],
        ['slug' => 'car-service', 'title' => 'Незамерзайка'],
        ['slug' => 'products', 'title' => 'Молоко'],
        ['slug' => 'products', 'title' => 'Кефир'],
        ['slug' => 'products', 'title' => 'Хлеб'],
        ['slug' => 'lunches,snacks', 'title' => 'Макдак'],
        ['slug' => 'internet', 'title' => 'Оплатил инет'],
        ['slug' => 'phone', 'title' => 'Пополнение баланса'],
        ['slug' => 'clothes', 'title' => 'Штаны'],
        ['slug' => 'clothes', 'title' => 'Рубашка'],
        ['slug' => 'rest', 'title' => 'Горный'],
        ['slug' => 'rest', 'title' => 'Тай'],
        ['slug' => 'household-goods', 'title' => 'Фейри'],
        ['slug' => 'household-goods', 'title' => 'Фейри'],
        ['slug' => 'rent', 'title' => 'Свет'],
        ['slug' => 'rent', 'title' => 'Вода'],
        ['slug' => 'childs', 'title' => 'Игрушки'],
        ['slug' => 'childs', 'title' => 'Сладости'],
        ['slug' => 'pharmacy,drugs', 'title' => 'Корвалол'],
        ['slug' => 'pharmacy,drugs', 'title' => 'Валерьянка'],
        ['slug' => 'therapy', 'title' => 'Массаж'],
        ['slug' => 'sport', 'title' => 'Спорт зал'],
        ['slug' => 'sport', 'title' => 'Инвентарь'],
        ['slug' => 'bank-interest', 'title' => 'Альфа-банк'],
        ['slug' => 'bank-interest', 'title' => 'Сбербанк'],
        ['slug' => 'salary', 'title' => 'Аванс'],
        ['slug' => 'salary', 'title' => 'Остаток']
    ];

    public function __construct(string $account_title)
    {
        $this->account_title = $account_title;
    }

    public function generateRow() :array
    {
        $ct = count($this->operations);
        $op_number = rand(0, $ct-1);
        $operation = $this->operations[$op_number];
        $title = $operation['title'];
        $slug = $operation['slug'];

        if ($slug === 'salary' || $slug === 'bank-interest') {
            $value = rand(10, 1000);
        } else {
            $value = rand(-100, -1);
        }
        $value *= 10;

        $operation_date = static::generateDate();

        $res = [
            'title' => $title,
            'value' => $value,
            'operation_date' => $operation_date,
            'slug' => $slug,
            'account_title' => $this->account_title
        ];

        return $res;
    }

    public static function generateDate() :string
    {
        $today = date("Y-m-d");
        list($todayY, $todayM, $todayD) = explode('-', $today);

        $d = rand(1, 28);
        if ($d < 10) {
            $d = '0'.$d;
        }

        $m = rand(1, $todayM);
        if ($m < 10) {
            $m = '0'.$m;
        }

        return "$todayY-$m-$d";
    }


    public function getJsonOperations(int $count) :string
    {
        $res = [];
        for ($i = 0; $i <= $count; $i++) {
            $res[] = $this->generateRow();
        }
        $res = json_encode($res);
        return $res;
    }
}
