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
            'name' => $this->string()->notNull(),
            'income' => $this->boolean()->notNull(),
            'id_parent' => $this->integer()->defaultValue(null),
        ]);

        $this->createTable('{{%accounts}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'value' => $this->integer()->defaultValue(0),
            'currency' => $this->string()->notNull(),
            'id_user' => $this->integer()->notNull()
        ]);

        $this->addForeignKey(
            'fk-accounts-id_user',
            'accounts',
            'id_user',
            'users',
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
        $this->dropTable('{{%categories}}');
        $this->dropTable('{{%accounts}}');
        $this->dropTable('{{%users}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180326_144646_addCategoryTable cannot be reverted.\n";

        return false;
    }
    */
}
