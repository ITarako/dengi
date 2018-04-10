<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "categories".
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property bool $income
 * @property int $id_parent
 *
 * @property Operation[] $operations
 * @property Category $parent
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'categories';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'slug'], 'trim'],
            [['title', 'slug'], 'unique'],
            [['title', 'slug'], 'string', 'min' => 2, 'max' => 255],
            [['title', 'slug', 'income'], 'required'],
            ['income', 'boolean'],
            ['id_parent', 'default', 'value' => null],
            ['id_parent', 'integer'],
            [
                'id_parent',
                'compare',
                'compareAttribute' => 'id',
                'operator' => '!==',
                'type' => 'number',
                'message' => 'Категория не может быть вложена в себя.'
            ]
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
            'slug' => 'Slug',
            'income' => 'Income',
            'id_parent' => 'Parent',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOperations()
    {
        return $this->hasMany(Operation::className(), ['id_category' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(static::className(), ['id' => 'id_parent']);
    }

    /**
     * @inheritdoc
     * @return CategoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CategoryQuery(get_called_class());
    }
}
