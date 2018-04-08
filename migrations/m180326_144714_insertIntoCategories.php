<?php

use yii\db\Migration;

/**
 * Class m180326_144714_insertIntoCategories
 */
class m180326_144714_insertIntoCategories extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert('{{%categories}}', ['name', 'income', 'id_parent'], [
            ['Автомобиль', 0, null],
            ['Еда', 0, null],
            ['Траты на жизнь', 0, null],
            ['Дом, семья', 0, null],
            ['Здоровье, красота', 0, null],
            ['Банковские проценты', 1, null],
            ['Зарплата', 1, null],
        ]);

        $tmp = \app\models\Category::findOne(['name' => 'Автомобиль']);
        $id = $tmp['id'];
        $this->batchInsert('{{%categories}}', ['name', 'income', 'id_parent'], [
            ['Бензин', 0, $id],
            ['Обслуживание авто', 0, $id]
        ]);

        $tmp = \app\models\Category::findOne(['name' => 'Еда']);
        $id = $tmp['id'];
        $this->batchInsert('{{%categories}}', ['name', 'income', 'id_parent'], [
            ['Продукты', 0, $id],
            ['Обеды, перекусы', 0, $id]
        ]);

        $tmp = \app\models\Category::findOne(['name' => 'Траты на жизнь']);
        $id = $tmp['id'];
        $this->batchInsert('{{%categories}}', ['name', 'income', 'id_parent'], [
            ['Интернет, связь', 0, $id],
            ['Одежда', 0, $id],
            ['Подарки', 0, $id],
            ['Отдых', 0, $id],
        ]);

        $tmp = \app\models\Category::findOne(['name' => 'Дом, семья']);
        $id = $tmp['id'];
        $this->batchInsert('{{%categories}}', ['name', 'income', 'id_parent'], [
            ['Хозтовары', 0, $id],
            ['Квартплата', 0, $id],
            ['Дети', 0, $id],
            ['Родителям', 0, $id],
        ]);

        $tmp = \app\models\Category::findOne(['name' => 'Здоровье, красота']);
        $id = $tmp['id'];
        $this->batchInsert('{{%categories}}', ['name', 'income', 'id_parent'], [
            ['Аптека, препараты', 0, $id],
            ['Лечение', 0, $id],
            ['Спорт', 0, $id],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        \Yii::$app->db->createCommand()->truncateTable('categories')->execute();
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180326_144714_insertIntoCategory cannot be reverted.\n";

        return false;
    }
    */
}
