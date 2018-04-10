<?php

use yii\db\Migration;

/**
 * Class m180326_053931_addBaseTables
 */
class m180326_053931_addBaseTables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%users}}', [
            'id' => $this->primaryKey(),
            'email' => $this->string()->notNull()->unique(),
            'username' => $this->string()->notNull()->unique(),
            'password_hash' => $this->string()->notNull(),
            'status' => $this->integer()->notNull()->defaultValue(app\models\User::STATUS_ACTIVE),
            'auth_key' => $this->string(32)
        ]);

        $this->createTable('{{%categories}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull()->unique(),
            'slug' => $this->string()->notNull()->unique(),
            'income' => $this->boolean()->notNull(),
            'id_parent' => $this->integer()->defaultValue(null),
        ]);

        $this->createTable('{{%currencies}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(50)->notNull()->unique(),
            'code' => $this->string(3)->notNull()->unique(),
        ]);

        /* $this->createIndex(
            'idx-currencies-code',
            'currencies',
            'code'
        ); */

        $this->createTable('{{%accounts}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'value' => $this->integer()->defaultValue(0),
            'id_user' => $this->integer()->notNull(),
            'id_currency' => $this->integer()->notNull()
        ]);

        $this->addForeignKey(
            'fk-accounts-id_user',
            'accounts',
            'id_user',
            'users',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-accounts-id_currency',
            'accounts',
            'id_currency',
            'currencies',
            'id',
            'CASCADE'
        );

        $this->createTable('{{%operations}}', [
            'id' => $this->primaryKey(),
            'value' => $this->integer()->notNull(),
            'id_account' => $this->integer()->notNull(),
            'id_category' => $this->integer()->notNull()
        ]);

        $this->addForeignKey(
            'fk-operations-id_account',
            'operations',
            'id_account',
            'accounts',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-operations-id_category',
            'operations',
            'id_category',
            'categories',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%operations}}');
        $this->dropTable('{{%accounts}}');
        $this->dropTable('{{%currencies}}');
        $this->dropTable('{{%categories}}');
        $this->dropTable('{{%users}}');
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
