<?php

use yii\db\Migration;
use \app\models\Category;

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
        $this->batchInsert('{{%categories}}', ['title', 'slug', 'income'], [
            ['Автомобиль', 'car', 0],
            ['Еда', 'food', 0],
            ['Траты на жизнь', 'spending-on-life', 0],
            ['Дом, семья', 'house,family', 0],
            ['Здоровье, красота', 'health,beauty', 0],
            ['Банковские проценты', 'bank-interest', 1],
            ['Зарплата', 'salary',1],
        ]);

        $tmp = Category::findOne(['slug' => 'car']);
        $id = $tmp['id'];
        $this->batchInsert('{{%categories}}', ['title', 'slug', 'income', 'id_parent'], [
            ['Бензин', 'petrol',0, $id],
            ['Обслуживание авто', 'car-service',0, $id]
        ]);

        $tmp = Category::findOne(['slug' => 'food']);
        $id = $tmp['id'];
        $this->batchInsert('{{%categories}}', ['title', 'slug', 'income', 'id_parent'], [
            ['Продукты', 'products',0 , $id],
            ['Обеды, перекусы', 'lunches,snacks',0 , $id]
        ]);

        $tmp = Category::findOne(['slug' => 'spending-on-life']);
        $id = $tmp['id'];
        $this->batchInsert('{{%categories}}', ['title', 'slug', 'income', 'id_parent'], [
            ['Интернет', 'internet',0 , $id],
            ['Телефон', 'phone',0 , $id],
            ['Одежда', 'clothes',0 , $id],
            ['Подарки', 'gifts',0 , $id],
            ['Отдых', 'rest',0 , $id],
        ]);

        $tmp = Category::findOne(['slug' => 'house,family']);
        $id = $tmp['id'];
        $this->batchInsert('{{%categories}}', ['title', 'slug', 'income', 'id_parent'], [
            ['Хозтовары', 'household-goods',0 , $id],
            ['Квартплата', 'rent',0 , $id],
            ['Дети', 'childs',0 , $id],
            ['Родителям', 'parents',0 , $id],
        ]);

        $tmp = Category::findOne(['slug' => 'health,beauty']);
        $id = $tmp['id'];
        $this->batchInsert('{{%categories}}', ['title', 'slug', 'income', 'id_parent'], [
            ['Аптека, препараты', 'pharmacy,drugs',0 , $id],
            ['Лечение', 'therapy',0 , $id],
            ['Спорт', 'sport',0 , $id],
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
        return false;
    }
    */
}
