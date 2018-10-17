<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Penceramah;

/**
 * PenceramahSearch represents the model behind the search form of `app\models\Penceramah`.
 */
class PenceramahSearch extends Penceramah
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'jenis_penceramah', 'nilai_kumpulan', 'tugas', 'taraf_jawatan', 'kelayakan', 'bulan', 'tahun', 'user'], 'integer'],
            [['kod_unjuran', 'kod_id', 'nama', 'bahagian', 'bahagian_asal', 'unit', 'no_kp', 'jawatan', 'gred_jawatan', 'no_gaji', 'jabatan', 'alamat_jabatan', 'no_hp', 'email', 'bank', 'akaun_bank', 'status', 'catatan', 'tarikh_jadi', 'tarikh_kemaskini'], 'safe'],
            [['gaji', 'jumlah_tuntutan', 'jumlah_kew'], 'number'],
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
        $query = Penceramah::find();

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
            'jenis_penceramah' => $this->jenis_penceramah,
            'nilai_kumpulan' => $this->nilai_kumpulan,
            'tugas' => $this->tugas,
            'taraf_jawatan' => $this->taraf_jawatan,
            'kelayakan' => $this->kelayakan,
            'gaji' => $this->gaji,
            'bulan' => $this->bulan,
            'tahun' => $this->tahun,
            'jumlah_tuntutan' => $this->jumlah_tuntutan,
            'jumlah_kew' => $this->jumlah_kew,
            'user' => $this->user,
            'tarikh_jadi' => $this->tarikh_jadi,
            'tarikh_kemaskini' => $this->tarikh_kemaskini,
        ]);

        $query->andFilterWhere(['like', 'kod_unjuran', $this->kod_unjuran])
            ->andFilterWhere(['like', 'kod_id', $this->kod_id])
            ->andFilterWhere(['like', 'nama', $this->nama])
            ->andFilterWhere(['like', 'bahagian', $this->bahagian])
            ->andFilterWhere(['like', 'bahagian_asal', $this->bahagian_asal])
            ->andFilterWhere(['like', 'unit', $this->unit])
            ->andFilterWhere(['like', 'no_kp', $this->no_kp])
            ->andFilterWhere(['like', 'jawatan', $this->jawatan])
            ->andFilterWhere(['like', 'gred_jawatan', $this->gred_jawatan])
            ->andFilterWhere(['like', 'no_gaji', $this->no_gaji])
            ->andFilterWhere(['like', 'jabatan', $this->jabatan])
            ->andFilterWhere(['like', 'alamat_jabatan', $this->alamat_jabatan])
            ->andFilterWhere(['like', 'no_hp', $this->no_hp])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'bank', $this->bank])
            ->andFilterWhere(['like', 'akaun_bank', $this->akaun_bank])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'catatan', $this->catatan]);

        return $dataProvider;
    }
}
