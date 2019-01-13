<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Syarikat;

/**
 * SyarikatSearch represents the model behind the search form of `app\models\Syarikat`.
 */
class SyarikatSearch extends Syarikat
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'terima'], 'integer'],
            [['kod', 'nama_syarikat', 'alamat', 'nama_pengurus', 'no_telefon', 'no_faks', 'emel', 'cawangan_bank', 'no_akaun', 'no_rujukan', 'tarikh_daftar', 'pkk', 'kelas_F1', 'kelas_F2', 'kelas_F3', 'kelas_F4', 'kelas_F5', 'kelas_F6', 'kelas_F7', 'kew', 'tarikh_luput_kew', 'kod_kepala0', 'kod_kepala1', 'kod_kepala2', 'cidb', 'pkk_elektrik', 'kepala_sub_kepala', 'kod_cukai', 'tarikh_jadi', 'tarikh_kemaskini', 'user'], 'safe'],
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
        $query = Syarikat::find();

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
            'tarikh_daftar' => $this->tarikh_daftar,
            'tarikh_luput_kew' => $this->tarikh_luput_kew,
            'terima' => $this->terima,
            'tarikh_jadi' => $this->tarikh_jadi,
            'tarikh_kemaskini' => $this->tarikh_kemaskini,
        ]);

        $query->andFilterWhere(['like', 'kod', $this->kod])
            ->andFilterWhere(['like', 'nama_syarikat', $this->nama_syarikat])
            ->andFilterWhere(['like', 'alamat', $this->alamat])
            ->andFilterWhere(['like', 'nama_pengurus', $this->nama_pengurus])
            ->andFilterWhere(['like', 'no_telefon', $this->no_telefon])
            ->andFilterWhere(['like', 'no_faks', $this->no_faks])
            ->andFilterWhere(['like', 'emel', $this->emel])
            ->andFilterWhere(['like', 'cawangan_bank', $this->cawangan_bank])
            ->andFilterWhere(['like', 'no_akaun', $this->no_akaun])
            ->andFilterWhere(['like', 'no_rujukan', $this->no_rujukan])
            ->andFilterWhere(['like', 'pkk', $this->pkk])
            ->andFilterWhere(['like', 'kelas_F1', $this->kelas_F1])
            ->andFilterWhere(['like', 'kelas_F2', $this->kelas_F2])
            ->andFilterWhere(['like', 'kelas_F3', $this->kelas_F3])
            ->andFilterWhere(['like', 'kelas_F4', $this->kelas_F4])
            ->andFilterWhere(['like', 'kelas_F5', $this->kelas_F5])
            ->andFilterWhere(['like', 'kelas_F6', $this->kelas_F6])
            ->andFilterWhere(['like', 'kelas_F7', $this->kelas_F7])
            ->andFilterWhere(['like', 'kew', $this->kew])
            ->andFilterWhere(['like', 'kod_kepala0', $this->kod_kepala0])
            ->andFilterWhere(['like', 'kod_kepala1', $this->kod_kepala1])
            ->andFilterWhere(['like', 'kod_kepala2', $this->kod_kepala2])
            ->andFilterWhere(['like', 'cidb', $this->cidb])
            ->andFilterWhere(['like', 'pkk_elektrik', $this->pkk_elektrik])
            ->andFilterWhere(['like', 'kepala_sub_kepala', $this->kepala_sub_kepala])
            ->andFilterWhere(['like', 'kod_cukai', $this->kod_cukai])
            ->andFilterWhere(['like', 'user', $this->user]);

        return $dataProvider;
    }
}
