<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Upload;

/**
 * UploadSearchModel represents the model behind the search form of `app\models\Upload`.
 */
class UploadSearchModel extends Upload
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'filesize', 'id_user'], 'integer'],
            [['filename', 'extension', 'path', 'uploaded_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = Upload::find();

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

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'filesize' => $this->filesize,
            'uploaded_at' => $this->uploaded_at,
            'id_user' => $this->id_user,
        ]);

        $query->andFilterWhere(['ilike', 'filename', $this->filename])
            ->andFilterWhere(['ilike', 'extension', $this->extension])
            ->andFilterWhere(['ilike', 'path', $this->path]);

        return $dataProvider;
    }
}
