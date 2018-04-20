<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Waran;

/**
 * WaranSearch represents the model behind the search form of `app\models\Waran`.
 */
class WaranSearch extends Waran
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['no_waran', 'tarikh_waran', 'status_waran', 'tahun', 'os', 'catatan', 'tarikh', 'user'], 'safe'],
            [['jumlah_waran'], 'number'],
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
        $query = Waran::find();

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
            'tarikh_waran' => $this->tarikh_waran,
            'jumlah_waran' => $this->jumlah_waran,
            'tarikh' => $this->tarikh,
        ]);

        $query->andFilterWhere(['like', 'no_waran', $this->no_waran])
            ->andFilterWhere(['like', 'status_waran', $this->status_waran])
            ->andFilterWhere(['like', 'tahun', $this->tahun])
            ->andFilterWhere(['like', 'os', $this->os])
            ->andFilterWhere(['like', 'catatan', $this->catatan])
            ->andFilterWhere(['like', 'user', $this->user]);

        return $dataProvider;
    }
}
