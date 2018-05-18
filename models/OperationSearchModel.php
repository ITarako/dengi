<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Operation;
use yii\helpers\ArrayHelper;

/**
 * OperationSearchModel represents the model behind the search form of `app\models\Operation`.
 */
class OperationSearchModel extends Operation
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'value', 'id_account', 'id_category'], 'integer'],
            [['title'], 'string'],
            [['operation_date'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Operation::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        if (!Yii::$app->user->can('admin')) {
            $accounts = Account::find()->where(['id_user' => Yii::$app->user->id])->asArray()->all();
            $accounts = ArrayHelper::getColumn($accounts, 'id');
            $query->andWhere(['in', 'id_account', $accounts]);
        }

        $query->with('account', 'category', 'currency', 'user');

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'value' => $this->value,
            'operation_date' => $this->operation_date,
        ]);

        $query->andFilterWhere(['ilike', 'title', $this->title]);

        return $dataProvider;
    }
}
