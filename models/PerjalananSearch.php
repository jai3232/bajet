<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Perjalanan;

/**
 * PerjalananSearch represents the model behind the search form of `app\models\Perjalanan`.
 */
class PerjalananSearch extends Perjalanan
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'cc', 'jumlah_jarak', 'jarak_telah_dituntut', 'kali_makan', 'kali_makan_sabah', 'kali_harian', 'kali_harian_sabah', 'kali_elaun_luar', 'kali_hotel', 'kali_hotel2', 'kali_hotel3', 'kali_hotel4', 'kali_hotel5', 'kali_hotel6', 'kali_lojing', 'resit_teksi', 'resit_bas', 'resit_keretapi', 'resit_terbang', 'resit_feri', 'resit_lain', 'resit_tol', 'resit_pakir', 'resit_dobi', 'resit_pos', 'resit_telefon', 'resit_tukaran', 'tuntutan_lain', 'status', 'cetak', 'user'], 'integer'],
            [['kod_unjuran', 'kod_id', 'os', 'bahagian', 'bahagian_asal', 'unit', 'nama', 'no_kp', 'no_hp', 'email', 'bulan', 'tahun', 'jawatan', 'no_gaji', 'bank', 'cawangan_bank', 'akaun_bank', 'model_kereta', 'no_plate', 'kelas_tuntutan', 'alamat_pejabat', 'alamat_rumah', 'no_tg', 'catatan', 'tarikh_jadi', 'tarikh_kemaskini'], 'safe'],
            [['gaji_asas', 'elaun', 'elaun_mangku', 'elaun_makan', 'elaun_makan_sabah', 'elaun_harian', 'elaun_harian_sabah', 'elaun_luar', 'peratus_elaun_makan', 'peratus_elaun_makan_sabah', 'peratus_elaun_harian', 'peratus_elaun_harian_sabah', 'peratus_elaun_luar', 'hotel', 'hotel2', 'hotel3', 'hotel4', 'hotel5', 'hotel6', 'cukai', 'lojing', 'teksi', 'bas', 'keretapi', 'terbang', 'feri', 'lain', 'tol', 'pakir', 'dobi', 'pos', 'telefon', 'tukaran', 'pendahuluan', 'jumlah_tuntutan', 'jumlah_kew'], 'number'],
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
        $query = Perjalanan::find();

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
            'gaji_asas' => $this->gaji_asas,
            'elaun' => $this->elaun,
            'elaun_mangku' => $this->elaun_mangku,
            'cc' => $this->cc,
            'jumlah_jarak' => $this->jumlah_jarak,
            'jarak_telah_dituntut' => $this->jarak_telah_dituntut,
            'kali_makan' => $this->kali_makan,
            'kali_makan_sabah' => $this->kali_makan_sabah,
            'kali_harian' => $this->kali_harian,
            'kali_harian_sabah' => $this->kali_harian_sabah,
            'kali_elaun_luar' => $this->kali_elaun_luar,
            'elaun_makan' => $this->elaun_makan,
            'elaun_makan_sabah' => $this->elaun_makan_sabah,
            'elaun_harian' => $this->elaun_harian,
            'elaun_harian_sabah' => $this->elaun_harian_sabah,
            'elaun_luar' => $this->elaun_luar,
            'peratus_elaun_makan' => $this->peratus_elaun_makan,
            'peratus_elaun_makan_sabah' => $this->peratus_elaun_makan_sabah,
            'peratus_elaun_harian' => $this->peratus_elaun_harian,
            'peratus_elaun_harian_sabah' => $this->peratus_elaun_harian_sabah,
            'peratus_elaun_luar' => $this->peratus_elaun_luar,
            'kali_hotel' => $this->kali_hotel,
            'kali_hotel2' => $this->kali_hotel2,
            'kali_hotel3' => $this->kali_hotel3,
            'kali_hotel4' => $this->kali_hotel4,
            'kali_hotel5' => $this->kali_hotel5,
            'kali_hotel6' => $this->kali_hotel6,
            'kali_lojing' => $this->kali_lojing,
            'hotel' => $this->hotel,
            'hotel2' => $this->hotel2,
            'hotel3' => $this->hotel3,
            'hotel4' => $this->hotel4,
            'hotel5' => $this->hotel5,
            'hotel6' => $this->hotel6,
            'cukai' => $this->cukai,
            'lojing' => $this->lojing,
            'teksi' => $this->teksi,
            'resit_teksi' => $this->resit_teksi,
            'bas' => $this->bas,
            'resit_bas' => $this->resit_bas,
            'keretapi' => $this->keretapi,
            'resit_keretapi' => $this->resit_keretapi,
            'terbang' => $this->terbang,
            'resit_terbang' => $this->resit_terbang,
            'feri' => $this->feri,
            'resit_feri' => $this->resit_feri,
            'lain' => $this->lain,
            'resit_lain' => $this->resit_lain,
            'tol' => $this->tol,
            'resit_tol' => $this->resit_tol,
            'pakir' => $this->pakir,
            'resit_pakir' => $this->resit_pakir,
            'dobi' => $this->dobi,
            'resit_dobi' => $this->resit_dobi,
            'pos' => $this->pos,
            'resit_pos' => $this->resit_pos,
            'telefon' => $this->telefon,
            'resit_telefon' => $this->resit_telefon,
            'tukaran' => $this->tukaran,
            'resit_tukaran' => $this->resit_tukaran,
            'pendahuluan' => $this->pendahuluan,
            'tuntutan_lain' => $this->tuntutan_lain,
            'jumlah_tuntutan' => $this->jumlah_tuntutan,
            'jumlah_kew' => $this->jumlah_kew,
            'status' => $this->status,
            'cetak' => $this->cetak,
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
            ->andFilterWhere(['like', 'bulan', $this->bulan])
            ->andFilterWhere(['like', 'tahun', $this->tahun])
            ->andFilterWhere(['like', 'jawatan', $this->jawatan])
            ->andFilterWhere(['like', 'no_gaji', $this->no_gaji])
            ->andFilterWhere(['like', 'bank', $this->bank])
            ->andFilterWhere(['like', 'cawangan_bank', $this->cawangan_bank])
            ->andFilterWhere(['like', 'akaun_bank', $this->akaun_bank])
            ->andFilterWhere(['like', 'model_kereta', $this->model_kereta])
            ->andFilterWhere(['like', 'no_plate', $this->no_plate])
            ->andFilterWhere(['like', 'kelas_tuntutan', $this->kelas_tuntutan])
            ->andFilterWhere(['like', 'alamat_pejabat', $this->alamat_pejabat])
            ->andFilterWhere(['like', 'alamat_rumah', $this->alamat_rumah])
            ->andFilterWhere(['like', 'no_tg', $this->no_tg])
            ->andFilterWhere(['like', 'catatan', $this->catatan]);

        return $dataProvider;
    }
}
