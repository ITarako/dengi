<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        Данное приложение поможет вам контролировать ваши деньги.
    </p>
    <p>
        Создано в рамках учебного курса "PHP Practice" для оттачивания навыка разработки веб-приложений с использованием фреймворка <a href="http://www.yiiframework.com/">Yii2</a>.
    </p>

</div>
