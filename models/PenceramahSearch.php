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
    public $os;

    public function rules()
    {
        return [
            [['id', 'jenis_penceramah', 'id_jabatan', 'id_jabatan_asal', 'id_unit', 'nilai_kumpulan', 'tugas', 'taraf_jawatan', 'kelayakan', 'bulan', 'tahun', 'user'], 'integer'],
            [['kod_unjuran', 'kod_id', 'os', 'nama', 'no_kp', 'jawatan', 'gred_jawatan', 'no_gaji', 'jabatan', 'alamat_jabatan', 'no_hp', 'email', 'bank', 'akaun_bank', 'status', 'catatan', 'tarikh_jadi', 'tarikh_kemaskini'], 'safe'],
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

        $level = Yii::$app->user->identity->level;
        $id_pengguna = Yii::$app->user->identity->id;
        $id_jabatan = Yii::$app->user->identity->id_jabatan;
        if($level == 5)
            $query->where(['id_jabatan_asal' => $id_jabatan]);
        if($level > 5)
            $query->where(['user' => $id_pengguna]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query->joinWith(['kodUnjuran']),
        ]);

        $this->load($params);

        $dataProvider->sort->attributes['os'] = [
            'asc' => ['unjuran.os' => SORT_ASC],
            'desc' => ['unjuran.os' => SORT_DESC],
        ];

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $this->tahun = isset($this->tahun) ? $this->tahun : date("Y");
        $this->bulan = isset($this->bulan) ? $this->bulan : date("m");

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'jenis_penceramah' => $this->jenis_penceramah,
            'nilai_kumpulan' => $this->nilai_kumpulan,
            'tugas' => $this->tugas,
            'taraf_jawatan' => $this->taraf_jawatan,
            'kelayakan' => $this->kelayakan,
            'gaji' => $this->gaji,
            'penceramah.bulan' => $this->bulan,
            'penceramah.tahun' => $this->tahun,
            'jumlah_tuntutan' => $this->jumlah_tuntutan,
            'jumlah_kew' => $this->jumlah_kew,
            'user' => $this->user,
            'tarikh_jadi' => $this->tarikh_jadi,
            'tarikh_kemaskini' => $this->tarikh_kemaskini,
        ]);

        $query->andFilterWhere(['like', 'kod_unjuran', $this->kod_unjuran])
            ->andFilterWhere(['like', 'kod_id', $this->kod_id])
            ->andFilterWhere(['like', 'unjuran.os', $this->os])
            ->andFilterWhere(['like', 'nama', $this->nama])
            ->andFilterWhere(['like', 'penceramah.id_jabatan', $this->id_jabatan])
            ->andFilterWhere(['like', 'penceramah.id_jabatan_asal', $this->id_jabatan_asal])
            ->andFilterWhere(['like', 'penceramah.id_unit', $this->id_unit])
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
