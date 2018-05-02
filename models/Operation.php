<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "operations".
 *
 * @property int $id
 * @property string $title
 * @property int $value
 * @property string $operation_date
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
            [['title', 'value', 'id_account', 'id_category'], 'required'],
            [['title', 'value', 'id_account', 'id_category'], 'default', 'value' => null],
            [['value', 'id_account', 'id_category'], 'integer'],
            [['title'], 'trim'],
            [['title'], 'string', 'min' => 2, 'max' => 255],
            [['operation_date'], 'safe'],
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
            'title' => 'Title',
            'value' => 'Value',
            'operation_date' => 'Date',
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
     * @return \yii\db\ActiveQuery
     */
    public function getCurrency()
    {
        return $this->hasOne(Currency::className(), ['id' => 'id_currency'])
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
