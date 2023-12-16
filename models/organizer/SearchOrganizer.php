<?php

namespace app\models\organizer;

use app\models\Organizer;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * SearchOrganizer represents the model behind the search form of `app\models\Organizer`.
 */
class SearchOrganizer extends Organizer
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['full_name', 'email', 'phone'], 'safe'],
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
        $query = Organizer::find()->joinWith(['events'])->groupBy(['organizer.id']);

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
            'organizer.id' => $this->id,
        ]);

        $query->andFilterWhere(['ilike', 'organizer.full_name', $this->full_name])
            ->andFilterWhere(['ilike', 'organizer.email', $this->email])
            ->andFilterWhere(['ilike', 'organizer.phone', $this->phone]);

        return $dataProvider;
    }
}
