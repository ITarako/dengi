<?php

use yii\db\Migration;

/**
 * Class m180514_035043_addUploads
 */
class m180514_035043_addUploads extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%uploads}}', [
            'id' => $this->primaryKey(),
            'filename' => $this->string()->notNull(),
            'filesize' => $this->integer()->notNull()->comment('Bytes'),
            'extension' => $this->string()->notNull(),
            'path' => $this->string()->notNull()->unique(),
            'uploaded_at' => 'timestamp with time zone NOT NULL',
            'id_user' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'fk-uploads-id_user',
            'uploads',
            'id_user',
            'users',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%uploads}}');

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180514_035041_addUploads cannot be reverted.\n";

        return false;
    }
    */
}
