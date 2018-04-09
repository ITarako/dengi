<?php

use yii\db\Migration;

/**
 * Class m180326_144715_insertIntoCurrenciesAndUsers
 */
class m180326_144715_insertIntoCurrenciesAndUsers extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert('{{%currencies}}', ['name', 'code'], [
            ['Euro', 'EUR'],
            ['US Dollar', 'USD'],
            ['Russian Ruble', 'RUB'],
            ['Bitcoin', 'BTC'],
            ['Ethereum', 'ETH'],
        ]);

        $this->Insert('{{%users}}', [
            'username'=>'admin',
            'email'=>'admin@admin.com',
            'password_hash'=>\Yii::$app->security->generatePasswordHash('qwerty'),
            'auth_key'=>\Yii::$app->security->generateRandomString()
            ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        \Yii::$app->db->createCommand('DELETE FROM users WHERE username="admin"')->execute();
        \Yii::$app->db->createCommand()->truncateTable('currencies')->execute();
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
