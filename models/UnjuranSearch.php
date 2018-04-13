<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Unjuran;

/**
 * UnjuranSearch represents the model behind the search form of `app\models\Unjuran`.
 */
class UnjuranSearch extends Unjuran
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_jabatan', 'id_unit', 'kuantiti', 'public', 'status', 'sah', 'user'], 'integer'],
            [['kod_id', 'os', 'ol', 'butiran', 'kod', 'kongsi', 'tahun', 'catatan', 'tarikh_jadi', 'tarikh_kemaskini'], 'safe'],
            [['jumlah_unjuran'], 'number'],
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
        $query = Unjuran::find();

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
            'id_jabatan' => $this->id_jabatan,
            'id_unit' => $this->id_unit,
            'kuantiti' => $this->kuantiti,
            'jumlah_unjuran' => $this->jumlah_unjuran,
            'public' => $this->public,
            'status' => $this->status,
            'sah' => $this->sah,
            'tarikh_jadi' => $this->tarikh_jadi,
            'tarikh_kemaskini' => $this->tarikh_kemaskini,
            'user' => $this->user,
        ]);

        $query->andFilterWhere(['like', 'kod_id', $this->kod_id])
            ->andFilterWhere(['like', 'os', $this->os])
            ->andFilterWhere(['like', 'ol', $this->ol])
            ->andFilterWhere(['like', 'butiran', $this->butiran])
            ->andFilterWhere(['like', 'kod', $this->kod])
            ->andFilterWhere(['like', 'kongsi', $this->kongsi])
            ->andFilterWhere(['like', 'tahun', $this->tahun])
            ->andFilterWhere(['like', 'catatan', $this->catatan]);

        return $dataProvider;
    }
}
