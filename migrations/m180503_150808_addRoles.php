<?php

use yii\db\Migration;

/**
 * Class m180503_150808_addRoles
 */
class m180503_150808_addRoles extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $rbac = \Yii::$app->authManager;

        $guest = $rbac->createRole('guest');
        $guest->description = 'Посетитель';
        $rbac->add($guest);

        $user = $rbac->createRole('user');
        $user->description = 'Пользователь';
        $rbac->add($user);

        $admin = $rbac->createRole('admin');
        $admin->description = 'Администратор';
        $rbac->add($admin);

        $rbac->addChild($admin, $user);
        $rbac->addChild($user, $guest);

        $rbac->assign(
            $admin,
            \app\models\User::findOne([
                'username' => 'admin'])->id
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $manager = \Yii::$app->authManager;
        $manager->removeAll();
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180503_150808_addRoles cannot be reverted.\n";

        return false;
    }
    */
}
