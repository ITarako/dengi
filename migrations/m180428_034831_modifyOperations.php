<?php

use yii\db\Migration;

/**
 * Class m180428_034831_modifyOperations
 */
class m180428_034831_modifyOperations extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%operations}}', 'title', $this->string()->notNull());

        $this->renameColumn('{{%operations}}', 'dt', 'operation_date');

        # https://github.com/yiisoft/yii2/issues/12077
        # $this->alterColumn('{{%operations}}', 'operation_date', $this->date()->notNull());
        $this->execute('ALTER TABLE "operations" ALTER COLUMN "operation_date" TYPE date, ALTER COLUMN "operation_date" SET NOT NULL');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('{{%operations}}', 'operation_date', 'timestamp with time zone');

        $this->renameColumn('{{%operations}}', 'operation_date', 'dt');

        $this->addColumn('{{%operations}}', 'title');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180428_034831_modifyOperations cannot be reverted.\n";

        return false;
    }
    */
}
