<?php

namespace app\models\event;

use app\models\Event;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * SearchEvent represents the model behind the search form of `app\models\Event`.
 */
class SearchEvent extends Event
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['date'], 'date', 'format' => 'php:Y-m-d'],
            [['name', 'description'], 'safe'],
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
        $query = Event::find()->joinWith(['organizers'])->groupBy(['event.id']);

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
            'event.id' => $this->id,
            'event.date' => $this->date,
        ]);

        $query->andFilterWhere(['ilike', 'event.name', $this->name])
            ->andFilterWhere(['ilike', 'event.description', $this->description]);

        return $dataProvider;
    }
}
