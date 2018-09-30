<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Ot;

/**
 * OtSearch represents the model behind the search form of `app\models\Ot`.
 */
class OtSearch extends Ot
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'bulan', 'tahun', 'tanggung_kerja', 'status', 'user'], 'integer'],
            [['kod_unjuran', 'kod_id', 'os', 'bahagian', 'bahagian_asal', 'unit', 'nama', 'no_kp', 'no_hp', 'email', 'gred_jawatan', 'jawatan', 'no_gaji', 'bank', 'akaun_bank', 'catatan', 'tarikh_jadi', 'tarikh_kemaskini'], 'safe'],
            [['gaji_asas', 'kadar_sejam', 'jumlah_OT', 'jumlah_kew'], 'number'],
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
        $query = Ot::find();

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
            'bulan' => $this->bulan,
            'tahun' => $this->tahun,
            'tanggung_kerja' => $this->tanggung_kerja,
            'gaji_asas' => $this->gaji_asas,
            'kadar_sejam' => $this->kadar_sejam,
            'jumlah_OT' => $this->jumlah_OT,
            'jumlah_kew' => $this->jumlah_kew,
            'status' => $this->status,
            'user' => $this->user,
            'tarikh_jadi' => $this->tarikh_jadi,
            'tarikh_kemaskini' => $this->tarikh_kemaskini,
        ]);

        $query->andFilterWhere(['like', 'kod_unjuran', $this->kod_unjuran])
            ->andFilterWhere(['like', 'kod_id', $this->kod_id])
            ->andFilterWhere(['like', 'os', $this->os])
            ->andFilterWhere(['like', 'bahagian', $this->bahagian])
            ->andFilterWhere(['like', 'bahagian_asal', $this->bahagian_asal])
            ->andFilterWhere(['like', 'unit', $this->unit])
            ->andFilterWhere(['like', 'nama', $this->nama])
            ->andFilterWhere(['like', 'no_kp', $this->no_kp])
            ->andFilterWhere(['like', 'no_hp', $this->no_hp])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'gred_jawatan', $this->gred_jawatan])
            ->andFilterWhere(['like', 'jawatan', $this->jawatan])
            ->andFilterWhere(['like', 'no_gaji', $this->no_gaji])
            ->andFilterWhere(['like', 'bank', $this->bank])
            ->andFilterWhere(['like', 'akaun_bank', $this->akaun_bank])
            ->andFilterWhere(['like', 'catatan', $this->catatan]);

        return $dataProvider;
    }
}
