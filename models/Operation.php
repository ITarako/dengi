<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "operations".
 *
 * @property int $id
 * @property int $value
 * @property string $dt
 * @property int $id_account
 * @property int $id_category
 *
 * @property Account $account
 * @property Category $category
 */
class Operation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'operations';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['value', 'id_account', 'id_category'], 'required'],
            [['value', 'id_account', 'id_category'], 'default', 'value' => null],
            [['value', 'id_account', 'id_category'], 'integer'],
            [['dt'], 'safe'],
            [['id_account'], 'exist', 'skipOnError' => true, 'targetClass' => Account::className(), 'targetAttribute' => ['id_account' => 'id']],
            [['id_category'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['id_category' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'value' => 'Value',
            'dt' => 'Datetime',
            'id_account' => 'Account',
            'id_category' => 'Category',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccount()
    {
        return $this->hasOne(Account::className(), ['id' => 'id_account']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'id_category']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'id_user'])
        ->viaTable('accounts', ['id'=>'id_account']);
    }

    /**
     * @inheritdoc
     * @return OperationQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new OperationQuery(get_called_class());
    }
}
