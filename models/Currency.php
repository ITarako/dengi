<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "currencies".
 *
 * @property int $id
 * @property string $title
 * @property string $code
 *
 * @property Account[] $accounts
 */
class Currency extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'currencies';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'code'], 'required'],
            [['title'], 'string', 'min'=>3, 'max' => 50],
            [['code'], 'string', 'min'=>3,'max' => 3],
            [['code','title'], 'unique'],
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
            'code' => 'Code',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccounts()
    {
        return $this->hasMany(Account::className(), ['id_user' => 'id']);
    }

    /**
     * @inheritdoc
     * @return CurrenciesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CurrenciesQuery(get_called_class());
    }
}
