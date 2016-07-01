<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\StaticType;

/**
 * StaticTypeSearch represents the model behind the search form about `backend\models\StaticType`.
 */
class StaticTypeSearch extends StaticType
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'type', 'editor_type', 'status', 'created_at', 'updated_at'], 'integer'],
            ['items_amount', 'integer', 'when' => function () {
                return !$this->isItemsAmountUnlimitedText();
            }, 'message' => Yii::t('yii', '{attribute} must be a number or "Unlimited".')],
            [['name'], 'safe'],
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
        $query = StaticType::find();

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
            'type' => $this->type,
            'items_amount' => $this->isItemsAmountUnlimitedText() ? self::AMOUNT_UNLIMITED : $this->items_amount,
            'editor_type' => $this->editor_type,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
